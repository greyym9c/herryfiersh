<?php
header("Content-Type: application/json");

// 1. Load Files (Use Absolute Paths)
$garapanFile = __DIR__ . '/garapan_data.json';
$configFile = __DIR__ . '/bot_config.json';
$logFile = __DIR__ . '/bot_log.json';

if (!file_exists($garapanFile)) {
    echo json_encode(['status' => 'error', 'message' => 'garapan_data.json not found']);
    exit;
}
if (!file_exists($configFile)) {
    echo json_encode(['status' => 'error', 'message' => 'bot_config.json not found. Please click SAVE in the web settings first.']);
    exit;
}

$garapanData = json_decode(file_get_contents($garapanFile), true);
$botConfig = json_decode(file_get_contents($configFile), true);
$botLog = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];

if (empty($botConfig['teleEnabled']) || empty($botConfig['teleToken']) || empty($botConfig['teleChatId'])) {
    echo json_encode(['status' => 'skipped', 'message' => 'Bot disabled or incomplete config']);
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

    list($h, $m) = explode(':', $item['jam']);
    $taskTimeVal = ($h * 60) + $m;
    $diff = $taskTimeVal - $currentTimeVal;

    // Trigger exactly 10 minutes before
    if ($diff === 10) {
        $logKey = "sent_" . $item['id'];
        
        // Check if already sent today
        if (in_array($logKey, $logEntries)) continue;

        // Send Telegram
        $chatIds = array_filter(array_map('trim', explode(',', $botConfig['teleChatId'])));
        
        foreach ($chatIds as $chatId) {
            $msg = "🔔 *PENGINGAT GARAPAN* (10 Menit Lagi)\n\n📌 *Projek:* " . $item['nama_garapan'] . 
                   "\n⏰ *Jam:* " . $item['jam'] . " WIB" .
                   "\n💰 *Promo:* Rp " . ($item['cashback'] ?? '0') . 
                   "\n📝 *Ket:* " . ($item['keterangan'] ?? '-');

            // Use cURL for better reliability and error capture
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $botConfig['teleToken'] . "/sendMessage");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'chat_id' => $chatId,
                'text' => $msg,
                'parse_mode' => 'Markdown'
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix for some hosting environs
            
            $server_output = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);

            // Log result for debug
            $logEntries[] = [
                'id' => $logKey,
                'chat_id' => $chatId,
                'http_code' => $http_code,
                'response' => json_decode($server_output, true),
                'curl_error' => $curl_error
            ];
            $sentCount++;
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
