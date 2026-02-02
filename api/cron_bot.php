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

// Clear PHP's stat cache to ensure we get fresh file info
clearstatcache();

$garapanData = json_decode(file_get_contents($garapanFile), true);
$botConfig = json_decode(file_get_contents($configFile), true);
$botLog = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
if (!is_array($botLog)) $botLog = [];

if ((empty($botConfig['teleEnabled']) || empty($botConfig['teleToken']) || empty($botConfig['teleChatId'])) && 
    (empty($botConfig['waEnabled']) || empty($botConfig['waApiKey']) || empty($botConfig['waRecipient']))) {
    echo json_encode(['status' => 'skipped', 'message' => 'Both Bots disabled or incomplete config']);
    exit;
}

// 2. Set Time Env
date_default_timezone_set("Asia/Jakarta");
$currentDate = date('Y-m-d');
$currentHour = date('H');
$currentMinute = date('i');
$currentTimeVal = ($currentHour * 60) + $currentMinute;

$sentCount = 0;
$logEntries = $botLog[$currentDate] ?? [];

// 3. Check Logic
foreach ($garapanData as $item) {
    if (empty($item['jam']) || $item['status'] !== 'active') continue;

    // Check Date Range (Period Logic)
    // If today is outside [tgl_mulai - tgl_selesai], SKIP.
    if (!empty($item['tgl_mulai']) && !empty($item['tgl_selesai'])) {
        if ($currentDate < $item['tgl_mulai'] || $currentDate > $item['tgl_selesai']) {
            continue;
        }
    }

    list($h, $m) = explode(':', $item['jam']);
    $taskTimeVal = ($h * 60) + $m;
    $diff = $taskTimeVal - $currentTimeVal;

    // Trigger exactly 10 minutes before
    if ($diff === 10) {
        $logKey = "sent_" . $item['id'];
        
        // Check if already sent today
        $sent_ids = array_column($logEntries, 'id');
        if (in_array($logKey, $sent_ids)) continue;

        // Send Telegram
        if (!empty($botConfig['teleEnabled']) && !empty($botConfig['teleToken']) && !empty($botConfig['teleChatId'])) {
            $chatIds = array_filter(array_map('trim', explode(',', $botConfig['teleChatId'])));
            
            // Debug Log
            error_log("Sending Telegram to IDs: " . implode(", ", $chatIds));
            
            foreach ($chatIds as $chatId) {
                $msg = "🔔 *PENGINGAT GARAPAN* (10 Menit Lagi)\n\n📌 *Projek:* " . $item['nama_garapan'] . 
                       "\n⏰ *Jam:* " . $item['jam'] . " WIB" .
                       "\n💰 *Promo:* Rp " . ($item['cashback'] ?? '0') . 
                       "\n📝 *Ket:* " . ($item['keterangan'] ?? '-');

                $ch = curl_init();
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

                $logEntries[] = [
                    'id' => $logKey,
                    'bot' => 'telegram',
                    'chat_id' => $chatId,
                    'http_code' => $http_code,
                    'response' => json_decode($server_output, true)
                ];
                $sentCount++;
            }
        }

        // Send WhatsApp (TextMeBot)
        if (!empty($botConfig['waEnabled']) && !empty($botConfig['waApiKey']) && !empty($botConfig['waRecipient'])) {
            $msg = "🔔 *PENGINGAT GARAPAN* (10 Menit Lagi)\n\n📌 *Projek:* " . $item['nama_garapan'] . 
                   "\n⏰ *Jam:* " . $item['jam'] . " WIB" .
                       "\n💰 *Promo:* Rp " . ($item['cashback'] ?? '0') . 
                       "\n📝 *Ket:* " . ($item['keterangan'] ?? '-');

            // Support Multiple Recipients (Comma Separated)
            $recipients = array_filter(array_map('trim', explode(',', $botConfig['waRecipient'])));

            foreach ($recipients as $number) {
                 // Sanitize recipient: remove all non-numeric characters (like +)
                $recipient = preg_replace('/[^0-9]/', '', $number);
                
                if (empty($recipient)) continue;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.textmebot.com/send.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'recipient' => $recipient,
                    'apikey' => $botConfig['waApiKey'],
                    'text' => $msg
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                
                $server_output = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // Handle 411 Disconnected
                if ($http_code === 411) {
                    $server_output = json_encode([
                        'error' => true,
                        'message' => 'WhatsApp Terputus (Disconnected). Silakan scan QR ulang di textmebot.com',
                        'raw' => strip_tags($server_output) // Clean HTML tags
                    ]);
                }

                $logEntries[] = [
                    'id' => $logKey,
                    'bot' => 'whatsapp',
                    'recipient' => $recipient,
                    'http_code' => $http_code,
                    'response' => ($http_code === 200) ? $server_output : json_decode($server_output)
                ];
                $sentCount++;

                // Anti-Ban Delay: TextMeBot requires 5s delay minimum
                sleep(8);
            }
        }
    }
}

// 4. Save Log
$botLog[$currentDate] = $logEntries;
// Cleanup old logs (keep only last 2 days to save space)
if (count($botLog) > 2) {
    $botLog = array_slice($botLog, -2, 2, true);
}
file_put_contents($logFile, json_encode($botLog));

// 5. Output for manual checking
echo json_encode([
    'status' => 'success',
    'server_time' => date('H:i') . ' WIB',
    'message' => "Checked " . count($garapanData) . " tasks.",
    'sent_count' => $sentCount,
    'api_responses' => $logEntries,
    'debug_log' => array_map(function($i) use ($currentTimeVal) {
        if(empty($i['jam'])) return null;
        list($h, $m) = explode(':', $i['jam']);
        $taskTime = ($h * 60) + $m;
        $diff = $taskTime - $currentTimeVal;
        return [
            'item' => $i['nama_garapan'],
            'jam' => $i['jam'],
            'diff_minutes' => $diff,
            'status' => ($diff === 10) ? 'TRIGGERED' : 'WAITING'
        ];
    }, $garapanData)
], JSON_PRETTY_PRINT);
?>
