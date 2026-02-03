<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$configFile = __DIR__ . '/bot_config.json';
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

$data = [
    'teleToken' => $input['teleToken'] ?? '',
    'teleChatId' => $input['teleChatId'] ?? '',
    'teleEnabled' => $input['teleEnabled'] ?? false,
    'mpwaApiKey' => $input['mpwaApiKey'] ?? '',
    'mpwaSender' => $input['mpwaSender'] ?? '',
    'waRecipient' => $input['waRecipient'] ?? '', // Group ID
    'waEnabled' => $input['waEnabled'] ?? false
];

if (file_put_contents($configFile, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['status' => 'success', 'message' => 'Config saved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save config']);
}
?>
