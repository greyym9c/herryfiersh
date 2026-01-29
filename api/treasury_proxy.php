<?php
header('Content-Type: application/json');

$url = "https://api.treasury.id/market/gold-price";

$ch = curl_init($url);
curl_setopt_array($ch,[
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Origin: https://web.treasury.id",
        "Referer: https://web.treasury.id/"
    ],
    CURLOPT_USERAGENT => "Mozilla/5.0",
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($httpCode !== 200 || !$response || !isset($data['data'])){
    // Fallback if API fails, so UI doesn't hang on "Loading..."
    echo json_encode([
        "source" => "fallback",
        "buy" => 1345000, 
        "sell" => 1295000,
        "timestamp" => time()
    ]);
    exit;
}

$buy  = (int)$data['data']['buy_price'];
$sell = (int)$data['data']['sell_price'];

echo json_encode([
    "source" => "treasury.id",
    "buy" => $buy,
    "sell" => $sell,
    "timestamp" => time()
]);
