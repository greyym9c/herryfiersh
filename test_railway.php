<?php
$url = "https://diiniindulu.up.railway.app/";

function test_url($url, $path = "") {
    $full_url = $url . $path;
    echo "Testing $full_url ...\n";
    $ch = curl_init($full_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Accept: application/json"],
        CURLOPT_TIMEOUT => 5
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Code: $code\n";
    echo "Start of body: " . substr($res, 0, 100) . "\n";
    if (json_decode($res)) {
        echo "Valid JSON!\n";
    } else {
        echo "Not JSON.\n";
    }
    echo "------------------\n";
}

test_url($url);
test_url($url, "api");
test_url($url, "api/price");
test_url($url, "price");
test_url($url, "gold-price");
test_url($url, "get_price");
?>
