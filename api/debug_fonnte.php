<?php
header("Content-Type: text/plain");
$configFile = __DIR__ . '/bot_config.json';
$token = "o7RofHHPHdm9Fa4Xa8gR"; // Hardcoded for safety

// Targets to test
$targets = [
    '120363405072231013@g.us', // Configured Group
    '120363405072231013',      // Group without @g.us
    '087775785980'             // Old sender number (User?)
];

$log = "Debug Start: " . date('Y-m-d H:i:s') . "\n";
$log .= "Token: $token\n\n";

foreach ($targets as $target) {
    // Fonnte API url
    $url = "https://api.fonnte.com/send";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
        'target' => $target,
        'message' => "Tes Fonnte ke $target", 
    ));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: $token"
    ));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    
    $log .= "Target: $target\n";
    $log .= "Error: $error\n";
    $log .= "Response: $response\n";
    $log .= "--------------------------------\n";
    
    curl_close($curl);
    sleep(2); // Prevent rate limit
}

file_put_contents(__DIR__ . '/debug_output.txt', $log);
echo "Debug finished. Data written to debug_output.txt";
?>
