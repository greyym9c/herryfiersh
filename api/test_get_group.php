<?php
header("Content-Type: text/plain");

$configFile = __DIR__ . '/bot_config.json';
$botConfig = json_decode(file_get_contents($configFile), true);
$token = $botConfig['fonnteToken'] ?? '';

if (empty($token)) die("Error: Token empty");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/get-whatsapp-group',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: ' . $token
  ),
));

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
    echo "Error: $error";
} else {
    echo "Response:\n$response";
}
?>
