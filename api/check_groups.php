<?php
header("Content-Type: text/plain");

// Load Config
$configFile = __DIR__ . '/bot_config.json';
if (!file_exists($configFile)) {
    die("Error: bot_config.json not found.");
}

$botConfig = json_decode(file_get_contents($configFile), true);
$token = $botConfig['fonnteToken'] ?? '';

if (empty($token)) die("Error: Fonnte Token is empty.");

echo "------------------------------------------------\n";
echo "Checking WhatsApp Groups for Token: " . substr($token, 0, 5) . "...\n";
echo "------------------------------------------------\n";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/fetch-group',
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
    echo "CURL Error: $error\n";
} else {
    $json = json_decode($response, true);
    
    if (isset($json['status']) && $json['status'] == true && isset($json['data'])) {
        echo "Found " . count($json['data']) . " groups.\n";
        echo "Dumping first group data for inspection:\n";
        print_r($json['data'][0]);
        echo "\n--------------------------------\n";
        
        foreach ($json['data'] as $group) {
            echo "Name: " . $group['name'] . "\n";
            echo "ID  : " . $group['id'] . "\n";
            echo "--------------------------------\n";
        }
    } else {
        echo "Response:\n" . $response . "\n";
    }
}
?>
