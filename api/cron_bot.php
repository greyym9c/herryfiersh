<?php
header("Content-Type: application/json");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 1. Load Files (Use Absolute Paths)
$garapanFile = __DIR__ . '/garapan_data.json';
$configFile = __DIR__ . '/bot_config.json';
$logFile = __DIR__ . '/bot_log.json';

if (!file_exists($garapanFile)) {
    echo json_encode(['status' => 'error', 'message' => 'garapan_data.json not found']);
    exit;
}
if (!file_exists($configFile)) {
    echo json_encode(['status' => 'error', 'message' => 'bot_config.json not found.']);
    exit;
}

// Clear PHP's stat cache
clearstatcache();

$garapanData = json_decode(file_get_contents($garapanFile), true);
$botConfig = json_decode(file_get_contents($configFile), true);
$botLog = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
if (!is_array($botLog)) $botLog = [];

if ((empty($botConfig['teleEnabled']) || empty($botConfig['teleToken']) || empty($botConfig['teleChatId'])) && 
    (empty($botConfig['waEnabled']) || empty($botConfig['fonnteToken']) || empty($botConfig['waRecipient']))) {
    echo json_encode(['status' => 'skipped', 'message' => 'Both Bots disabled or incomplete config']);
    exit;
}

// 2. Set Time Env
date_default_timezone_set("Asia/Jakarta");
$currentDate = date('Y-m-d');
$currentHour = date('H');
$currentMinute = date('i');
$currentTimeVal = ($currentHour * 60) + $currentMinute;

$triggeredItems = [];
$logEntries = $botLog[$currentDate] ?? [];

// 3. Check Logic
foreach ($garapanData as $item) {
    if (empty($item['jam']) || $item['status'] !== 'active') continue;

    // Check Date Range Strict
    if (!empty($item['tgl_mulai']) && $currentDate < $item['tgl_mulai']) continue;
    if (!empty($item['tgl_selesai']) && $currentDate > $item['tgl_selesai']) continue;

    list($h, $m) = explode(':', $item['jam']);
    $taskTimeVal = ($h * 60) + $m;
    
    // Circular Time Difference Calculation (10 mins before)
    $minutesUntil = ($taskTimeVal - $currentTimeVal + 1440) % 1440;

    if ($minutesUntil === 10) {
        // Special Check for Midnight Rollover
        if ($taskTimeVal < $currentTimeVal) { 
             $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
             if (!empty($item['tgl_selesai']) && $tomorrowDate > $item['tgl_selesai']) {
                 continue; 
             }
        }

        // Unique Log Key
        $logKey = "sent_" . $item['id'] . "_" . str_replace(':', '', $item['jam']);
        
        // Check if already sent
        $sent_ids = array_column($logEntries, 'id');
        if (in_array($logKey, $sent_ids)) continue;

        // Add to triggered list
        $item['logKey'] = $logKey; // Store key for logging later
        $triggeredItems[] = $item;
    }
}

// 4. Send Aggregated Message
$sentCount = 0;
if (!empty($triggeredItems)) {
    // Construct Message
    $msg = "🔔 *PENGINGAT GARAPAN* (10 Menit Lagi)\n";
    $msg .= "Total: " . count($triggeredItems) . " garapan\n\n";

    foreach ($triggeredItems as $idx => $t) {
        $msg .= ($idx + 1) . ". *" . $t['nama_garapan'] . "*\n";
        $msg .= "   ⏰ Jam: " . $t['jam'] . " WIB\n";
        $msg .= "   💰 CB: Rp " . ($t['cashback'] ?? '0') . "\n";
        $msg .= "   📝 " . ($t['keterangan'] ?? '-') . "\n\n";
    }

    // Send Telegram
    if (!empty($botConfig['teleEnabled']) && !empty($botConfig['teleToken']) && !empty($botConfig['teleChatId'])) {
        $chatIds = array_filter(array_map('trim', explode(',', $botConfig['teleChatId'])));
        
        foreach ($chatIds as $chatId) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $botConfig['botToken'] . "/sendMessage"); // Fix: check key name, usually teleToken
            // Wait, previous code used $botConfig['teleToken']. My snippet above used 'botToken' by mistake in the URL line? 
            // Checking previous file... it was $botConfig['teleToken'].
            // Retrying with correct key.
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $botConfig['teleToken'] . "/sendMessage");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'chat_id' => $chatId,
                'text' => $msg,
                'parse_mode' => 'Markdown'
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $server_output = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // We log the *batch* sending, but we need to record individual items as "sent" to avoid resending
            // Log entry will be per item, referencing this batch send? 
            // Or just log each item.
        }
    }

    // Send WhatsApp (Fonnte)
    if (!empty($botConfig['waEnabled']) && !empty($botConfig['fonnteToken']) && !empty($botConfig['waRecipient'])) {
        $recipients = array_filter(array_map('trim', explode(',', $botConfig['waRecipient'])));
        
        foreach ($recipients as $number) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.fonnte.com/send',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30, // Increased timeout
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array(
                'target' => $number,
                'message' => $msg . (empty($botConfig['waMembers']) ? "" : "\n\n" . implode(" ", array_map(function($n){ return "@" . trim($n); }, explode(",", $botConfig['waMembers'])))),
              ),
              CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $botConfig['fonnteToken']
              ),
              CURLOPT_SSL_VERIFYPEER => false
            ));

            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);
            
            // Log Fonnte Response
            $logEntries[] = [
                'id' => 'fonnte_debug_' . time(),
                'bot' => 'whatsapp_fonnte',
                'timestamp' => date('Y-m-d H:i:s'),
                'recipient' => $number,
                'response' => json_decode($response, true) ?? $response,
                'error' => $error
            ];

            // Sleep for rate limit
            sleep(2);
        }
    }

    // Log All Triggered Items
    foreach ($triggeredItems as $t) {
        $logEntries[] = [
            'id' => $t['logKey'],
            'bot' => 'hybrid',
            'timestamp' => date('Y-m-d H:i:s'),
            'status' => 'sent_in_batch'
        ];
        $sentCount++;
    }
}

// 5. Save Log
$botLog[$currentDate] = $logEntries;
if (count($botLog) > 2) {
    $botLog = array_slice($botLog, -2, 2, true);
}
file_put_contents($logFile, json_encode($botLog));

// 6. Output
echo json_encode([
    'status' => 'success',
    'server_time' => date('H:i') . ' WIB',
    'message' => "Checked " . count($garapanData) . " tasks. Batched " . count($triggeredItems) . " items.",
    'sent_count' => $sentCount, // Total items sent (batched)
    'debug_log' => array_map(function($i) use ($currentTimeVal) {
        if(empty($i['jam'])) return null;
        list($h, $m) = explode(':', $i['jam']);
        $taskTime = ($h * 60) + $m;
        $minutesUntil = ($taskTime - $currentTimeVal + 1440) % 1440;
        return [
            'item' => $i['nama_garapan'],
            'jam' => $i['jam'],
            'minutes_until' => $minutesUntil
        ];
    }, $garapanData)
], JSON_PRETTY_PRINT);
?>
