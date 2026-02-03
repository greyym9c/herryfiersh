<?php
header('Content-Type: text/html');

// Load config
$configFile = __DIR__ . '/bot_config.json';
if (!file_exists($configFile)) {
    die("Config file not found.");
}
$config = json_decode(file_get_contents($configFile), true);

$apiKey = $config['waApiKey'];
$recipient = $config['waRecipient']; // The Group ID
$message = "Test message from API debug script at " . date("H:i:s");

echo "<h3>Debug WhatsApp Sending</h3>";
echo "API Key: " . htmlspecialchars($apiKey) . "<br>";
echo "Recipient: " . htmlspecialchars($recipient) . "<br>";
echo "Message: " . htmlspecialchars($message) . "<br><hr>";

// Test 1: Standard Send
echo "<h4>Attempt 1: Standard send.php</h4>";
$url = "https://api.textmebot.com/send.php";
$data = [
    'recipient' => $recipient,
    'apikey' => $apiKey,
    'text' => $message
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "HTTP Code: " . $info['http_code'] . "<br>";
echo "Response: " . $output . "<br>";

// Test 2: Check Status/Info (if possible, to verify connection)
echo "<hr><h4>Attempt 2: Check API Key/Status</h4>";
// Some APIs have a /status or /check endpoint. Let's try to get group info if possible or just verify the key works for a self-message if user had a number.
// Since we only have group ID, we'll skip self-message unless user provides one.

echo "Done.";
?>
