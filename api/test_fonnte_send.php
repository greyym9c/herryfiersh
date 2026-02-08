<?php
header("Content-Type: text/plain");

// 1. Load Config
$configFile = __DIR__ . '/bot_config.json';
if (!file_exists($configFile)) {
    die("Error: bot_config.json not found.");
}

$botConfig = json_decode(file_get_contents($configFile), true);

$token = $botConfig['fonnteToken'] ?? '';
$target = $botConfig['waRecipient'] ?? '';

if (empty($token)) die("Error: Fonnte Token is empty in config.");
if (empty($target)) die("Error: WhatsApp Target is empty in config.");

echo "------------------------------------------------\n";
echo "Fonnte Notification Tester\n";
echo "------------------------------------------------\n";
echo "Token: " . substr($token, 0, 5) . "...\n";
echo "Target: $target\n\n";

// 2. Prepare Message
$msg = "🔔 *TES NOTIFIKASI FONNTE*\n\n";
$msg .= "Ini adalah pesan tes manual untuk memastikan bot berjalan.\n";
$msg .= "Waktu Server: " . date('d-m-Y H:i:s') . " WIB\n";

// 3. Send
echo "Sending message...\n";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
    'target' => $target,
    'message' => $msg,
  ),
  CURLOPT_HTTPHEADER => array(
    'Authorization: ' . $token
  ),
  CURLOPT_SSL_VERIFYPEER => false
));

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

echo "------------------------------------------------\n";
if ($error) {
    echo "CURL Error: $error\n";
} else {
    echo "API Response:\n";
    echo $response . "\n";
    
    $json = json_decode($response, true);
    if (isset($json['status']) && $json['status'] == false) {
        echo "\n[!] FAILED: " . ($json['reason'] ?? 'Unknown reason') . "\n";
        
        if (strpos($response, 'invalid group id') !== false) {
             echo "Possible Cause: The bot is not a participant of the group or Group ID has changed.\n";
        }
    } else {
        echo "\n[+] SUCCESS! Message sent to Fonnte queue.\n";
    }
}
echo "------------------------------------------------\n";
?>
