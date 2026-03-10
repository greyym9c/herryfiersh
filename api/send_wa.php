<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit;
}

$msg = $input['message'];
$configFile = __DIR__ . '/bot_config.json';
if (!file_exists($configFile)) {
    echo json_encode(['error' => 'Config not found']);
    exit;
}

$botConfig = json_decode(file_get_contents($configFile), true);

if (empty($botConfig['waEnabled']) || empty($botConfig['fonnteToken']) || empty($botConfig['waRecipient'])) {
    echo json_encode(['error' => 'WhatsApp not configured or disabled']);
    exit;
}

$recipients = array_filter(array_map('trim', explode(',', $botConfig['waRecipient'])));
$results = [];

foreach ($recipients as $number) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.fonnte.com/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'target' => $number,
        'message' => $msg
    ]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $botConfig['fonnteToken']
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    $results[] = [
        'target' => $number,
        'http_code' => $http_code,
        'response' => json_decode($response, true) ?? $response,
        'error' => $error
    ];
    
    sleep(1); // Small delay to avoid rate limiting
}

echo json_encode(['success' => true, 'results' => $results]);
?>
