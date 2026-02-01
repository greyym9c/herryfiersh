<?php
$file = __DIR__ . '/bot_config.json';
// Try to create if not exists
if (!file_exists($file)) {
    echo "File not found. Creating...\n";
    $defaultData = [
        'teleToken' => '8114128194:AAH5S2k2kTtigRnjA9zD2YbwN3vA8W3_pjU',
        'teleChatId' => '',
        'teleEnabled' => false
    ];
    if (file_put_contents($file, json_encode($defaultData, JSON_PRETTY_PRINT))) {
        echo "File created successfully.\n";
    } else {
        echo "Failed to create file.\n";
    }
}

// Fix permissions
echo "Fixing permissions...\n";
if (chmod($file, 0666)) {
    echo "Permissions set to 0666.\n";
} else {
    echo "Failed to set permissions.\n";
}

// Read back
echo "Content:\n" . file_get_contents($file) . "\n";
?>
