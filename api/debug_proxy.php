<?php
// api/debug_proxy.php
header('Access-Control-Allow-Origin: *');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = 'https://web.treasury.id/savings';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, ''); // Handle gzip

$html = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    exit;
}

curl_close($ch);

echo "<h1>Raw HTML Dump (view source)</h1>";
echo "<textarea style='width:100%; height:500px;'>" . htmlspecialchars($html) . "</textarea>";
