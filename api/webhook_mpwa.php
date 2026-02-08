<?php
header("Content-Type: application/json");
date_default_timezone_set("Asia/Jakarta");

// 1. Load Configurations
$configFile = __DIR__ . '/bot_config.json';
$garapanFile = __DIR__ . '/garapan_data.json';
$logFile = __DIR__ . '/webhook_log.txt';

if (!file_exists($configFile) || !file_exists($garapanFile)) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Config or Data file missing']);
    exit;
}

$botConfig = json_decode(file_get_contents($configFile), true);
$garapanData = json_decode(file_get_contents($garapanFile), true);

// 2. Receive Webhook Data (Fonnte)
// Fonnte sends data via POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Fallback to $_POST if JSON decode fails or input is empty (Fonnte often uses Form Data)
if (!$data && !empty($_POST)) {
    $data = $_POST;
}

// Log Incoming Data
file_put_contents($logFile, date('Y-m-d H:i:s') . " - INCOMING: " . json_encode($data) . "\n", FILE_APPEND);

// 3. Extract Message Details (Fonnte Structure)
// Fonnte Payload: sender, message, name, group (optional)
$sender = $data['sender'] ?? '';
$message = $data['message'] ?? '';
$group = $data['group'] ?? ''; // Group ID or Name
// Note: Fonnte 'group' field usually contains the Group Name or ID. 
// If it's a private chat, 'group' might be empty.

// 4. Validate Group
// User wants to allow adding task ONLY from the specific group.
$allowedGroup = $botConfig['waRecipient'] ?? '';

// Check if the message is from the allowed group.
// Fonnte might send the Group ID in 'group' field.
// If valid group, we proceed. We trust 'group' field matches 'waRecipient' OR 'sender' matches (if private testing).
// However, user specifically said "id grub juga sama", so we expect 'group' to match 'waRecipient'.
$isValidGroup = false;

if (!empty($group)) {
    // Check if the incoming group ID matches the allowed group ID
    // Note: strict comparison might fail if Fonnte formatting differs (e.g. suffixes). 
    // We'll try loose check or exact match.
    if (trim($group) === trim($allowedGroup)) {
        $isValidGroup = true;
    }
} else {
    // Direct message? Maybe allow for testing if sender matches allowed (unlikely for group ID)
}

if (!$isValidGroup) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - IGNORED: Group '$group' does not match allowed '$allowedGroup'\n", FILE_APPEND);
    // Don't exit abruptly, just return success to Fonnte so it stops retrying, but don't process.
    echo json_encode(['status' => 'ignored', 'message' => 'Invalid group']);
    exit;
}

// 5. Parse Command
// Command format: /add Nama Garapan | Jam | Keterangan
if (strpos(strtolower($message), '/add') === 0) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - COMMAND DETECTED: $message\n", FILE_APPEND);
    
    $rawContent = trim(substr($message, 4)); // Remove '/add'
    $parts = explode('|', $rawContent);
    $parts = array_map('trim', $parts);

    if (count($parts) >= 1) {
        $name = $parts[0];
        $time = $parts[1] ?? '00:00';
        $desc = $parts[2] ?? '-';
        
        // Basic Validation
        if (empty($name)) {
             replyMessage("monitor: Nama garapan tidak boleh kosong.\nFormat: /add Nama | Jam | Keterangan", $botConfig, $group); // Reply to group
             exit;
        }

        // Add to Data
        $newItem = [
            "id" => uniqid('wa_'),
            "nama_garapan" => $name,
            "jam" => $time,
            "periode" => "Harian", 
            "cashback" => "0",
            "keterangan" => $desc,
            "tgl_mulai" => date('Y-m-d'),
            "tgl_selesai" => "2030-12-31",
            "status" => "active",
            "prioritas" => "3"
        ];
        
        $garapanData[] = $newItem;
        
        // Save
        if (file_put_contents($garapanFile, json_encode($garapanData, JSON_PRETTY_PRINT))) {
            $reply = "✅ *Garapan Ditambahkan*\n";
            $reply .= "Nama: $name\n";
            $reply .= "Jam: $time\n";
            $reply .= "Ket: $desc";
            replyMessage($reply, $botConfig, $group); // Reply to group
        } else {
            replyMessage("❌ Gagal menyimpan data.", $botConfig, $group);
        }

    } else {
        replyMessage("⚠ Format salah.\nGunakan: /add Nama | Jam | Keterangan", $botConfig, $group);
    }
} else {
    echo json_encode(['status' => 'active', 'message' => 'Not a command']);
}

// Helper Function to Send Reply (Fonnte)
function replyMessage($msg, $config, $target) {
    global $logFile;

    if (empty($config['fonnteToken'])) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Error: Missing Fonnte Token\n", FILE_APPEND);
        return;
    }
    
    // Fonnte Send API
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'target' => $target, // Reply to the group (or sender)
        'message' => $msg,
      ),
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $config['fonnteToken']
      ),
      CURLOPT_SSL_VERIFYPEER => false
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Reply Sent. Code: $httpCode. Response: $response. Error: $error\n", FILE_APPEND);
}
?>
