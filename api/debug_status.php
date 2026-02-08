<?php
header("Content-Type: text/plain");
// Hardcoded token to eliminate config file parsing issues
$token = "2u1nDQhmyDkohfp7YCUTh5vVyPSGud8of"; 

echo "Checking Fonnte Status for token: $token\n";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/device/status',
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
  CURLOPT_SSL_VERIFYPEER => false
));

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
    echo "Curl Error: $error\n";
} else {
    echo "Response: $response\n";
}
?>
