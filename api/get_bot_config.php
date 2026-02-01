<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$configFile = __DIR__ . '/bot_config.json';

if (file_exists($configFile)) {
    echo file_get_contents($configFile);
} else {
    // Return default empty structure if file doesn't exist
    echo json_encode([
        'teleToken' => '',
        'teleChatId' => '',
        'teleEnabled' => false
    ]);
}
?>
