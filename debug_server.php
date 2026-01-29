<?php
header('Content-Type: text/plain');
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Current Script: " . __FILE__ . "\n";
echo "File Exists (assets/css/style.css): " . (file_exists(__DIR__ . '/assets/css/style.css') ? 'YES' : 'NO') . "\n";
echo "Directory Listing (assets/css): \n";
if (is_dir(__DIR__ . '/assets/css')) {
    print_r(scandir(__DIR__ . '/assets/css'));
} else {
    echo "assets/css is NOT a directory\n";
}
echo "\n";
echo "Directory Listing (.): \n";
print_r(scandir(__DIR__));
?>
