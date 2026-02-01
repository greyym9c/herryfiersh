<?php
header("Content-Type: application/json");

// 1. Load Files
$garapanFile = 'garapan_data.json';
$configFile = 'bot_config.json';
$logFile = 'bot_log.json';

if (!file_exists($garapanFile) || !file_exists($configFile)) {
    echo json_encode(['status' => 'error', 'message' => 'Data or Config not found']);
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

            $url = "https://api.telegram.org/bot" . $botConfig['teleToken'] . 
                   "/sendMessage?chat_id=" . $chatId . 
                   "&text=" . urlencode($msg) . "&parse_mode=Markdown";
            
            // Simple GET request
            file_get_contents($url);
        }

        // Log success
        $logEntries[] = $logKey;
        $sentCount++;
    }
}

// 4. Save Log
$botLog[$currentDate] = $logEntries;
// Cleanup old logs (keep only last 2 days to save space)
if (count($botLog) > 2) {
    $botLog = array_slice($botLog, -2, 2, true);
}
file_put_contents($logFile, json_encode($botLog));

echo json_encode([
    'status' => 'success',
    'time_checked' => date('H:i:s'), 
    'sent_count' => $sentCount
]);
?>
