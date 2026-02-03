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

// 2. Receive Webhook Data
// 2. Logging & Input Handling
$input = file_get_contents('php://input');
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Method: " . $_SERVER['REQUEST_METHOD'] . " - Input: " . $input . "\n", FILE_APPEND);

// Handle GET requests (Browser checks)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['status' => 'active', 'message' => 'Webhook is ready. Please set this URL in your MPWA dashboard.']);
    exit;
}

// Parse Data (JSON or POST)
$data = json_decode($input, true);
if (!$data) {
    // Try fallback to standard POST data if JSON failed
    if (!empty($_POST)) {
        $data = $_POST;
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Fallback to _POST: " . json_encode($_POST) . "\n", FILE_APPEND);
    } else {
        echo json_encode(['status' => 'ignored', 'message' => 'No data received. Make sure MPWA is sending a POST request.']);
        exit;
    }
}

// 3. Extract Message Details
// MPWA structure variation support. 
// Assuming checking for 'message', 'text', 'body' or 'conversation'
// And 'remote_jid', 'chat_id' or 'from'
$sender = $data['remote_jid'] ?? $data['chat_id'] ?? $data['from'] ?? '';
$message = $data['message']['conversation'] ?? $data['text'] ?? $data['body'] ?? '';

// Support for extended text messages (replies etc) if structure is complex
if (empty($message) && isset($data['message']['extendedTextMessage']['text'])) {
    $message = $data['message']['extendedTextMessage']['text'];
}

// 4. Validate Group/Sender
// User wants to add garapan "via chat wa di grub dengan id grub yang sama"
// So we must verify the sender is the configured Group ID
$allowedGroup = $botConfig['waRecipient'] ?? '';

if (trim($sender) !== trim($allowedGroup)) {
    echo json_encode(['status' => 'ignored', 'message' => 'Invalid group/sender', 'got' => $sender, 'expected' => $allowedGroup]);
    exit;
}

// 5. Parse Command
// Command format: /add Nama Garapan | Jam | Keterangan
// Example: /add MyTask | 10:00 | Cashback 10k
if (strpos(strtolower($message), '/add') === 0) {
    $rawContent = trim(substr($message, 4)); // Remove '/add'
    $parts = explode('|', $rawContent);
    $parts = array_map('trim', $parts);

    if (count($parts) >= 1) {
        $name = $parts[0];
        $time = $parts[1] ?? '00:00';
        $desc = $parts[2] ?? '-';
        
        // Basic Validation
        if (empty($name)) {
             replyMessage("Nama garapan tidak boleh kosong.\nFormat: /add Nama | Jam | Keterangan", $botConfig);
             exit;
        }

        // Add to Data
        $newItem = [
            "id" => uniqid('wa_'),
            "nama_garapan" => $name,
            "jam" => $time,
            "periode" => "Harian", // Defaulting to Harian for now
            "cashback" => "0", // Default
            "keterangan" => $desc,
            "tgl_mulai" => date('Y-m-d'),
            "tgl_selesai" => "2030-12-31", // Long term default
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
            replyMessage($reply, $botConfig);
        } else {
            replyMessage("❌ Gagal menyimpan data.", $botConfig);
        }

    } else {
        replyMessage("⚠ Format salah.\nGunakan: /add Nama | Jam | Keterangan", $botConfig);
    }
} else {
    echo json_encode(['status' => 'active', 'message' => 'Not a command']);
}

// Helper Function to Send Reply (Same as cron logic)
function replyMessage($msg, $config) {
    global $logFile; // Access global log file

    if (empty($config['mpwaApiKey']) || empty($config['mpwaBaseUrl'])) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Error: Missing API Key or URL in config\n", FILE_APPEND);
        return;
    }
    
    $payload = [
        'api_key' => $config['mpwaApiKey'],
        'sender' => $config['mpwaSender'] ?? '628123456789', // Recipient of the API (User's Sender Number)
        'number' => $config['waRecipient'], // The group to reply to
        'message' => $msg
    ];

    $ch = curl_init();
    // Correct Endpoint: https://app.mpwa.net/send-message
    curl_setopt($ch, CURLOPT_URL, ($config['mpwaBaseUrl']) . "/send-message");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // Log the result
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Reply Sent. Code: $httpCode. Response: $response. Error: $error\n", FILE_APPEND);
}
?>
