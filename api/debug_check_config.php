<?php
$file = __DIR__ . '/bot_config.json';
echo "Checking file: $file\n";
if (file_exists($file)) {
    echo "Status: EXISTS\n";
    echo "Content:\n" . file_get_contents($file) . "\n";
} else {
    echo "Status: NOT FOUND\n";
}
?>
