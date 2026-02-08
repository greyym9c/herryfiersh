<?php
header('Content-Type: application/json');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$file_path = __DIR__ . '/garapan_data.json';

// Function to read data
function read_data($path) {
    if (!file_exists($path)) {
        return [];
    }
    $content = file_get_contents($path);
    return json_decode($content, true) ?: [];
}

// Function to save data
function save_data($path, $data) {
    file_put_contents($path, json_encode(array_values($data), JSON_PRETTY_PRINT));
}

$method = $_SERVER['REQUEST_METHOD'];
$data = read_data($file_path);

switch ($method) {
    case 'GET':
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            break;
        }

        if (isset($input['id']) && $input['id'] !== '') {
            // Update
            foreach ($data as &$item) {
                if ($item['id'] == $input['id']) {
                    $item = array_merge($item, $input);
                    break;
                }
            }
        } else {
            // Create
            $input['id'] = uniqid();
            $data[] = $input;

            // --- Instant Notification Logic (MPWA) ---
            $configFile = __DIR__ . '/bot_config.json';
            if (file_exists($configFile)) {
                $botConfig = json_decode(file_get_contents($configFile), true);
                
                if (!empty($botConfig['waEnabled']) && !empty($botConfig['fonnteToken']) && !empty($botConfig['waRecipient'])) {
                    $newItem = $input;
                    $msg = "✅ *GARAPAN BARU DITAMBAHKAN*\n\n";
                    $msg .= "📌 *" . ($newItem['nama_garapan'] ?? 'Tanpa Nama') . "*\n";
                    $msg .= "⏰ Jam: " . ($newItem['jam'] ?? '-') . " WIB\n";
                    $msg .= "💰 Promo: Rp " . ($newItem['cashback'] ?? '0') . "\n";
                    $msg .= "📝 Ket: " . ($newItem['keterangan'] ?? '-') . "\n\n";
                    $msg .= "_Ditambahkan via Web_";

                    // Send Fonnte
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.fonnte.com/send");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, [
                        'target' => $botConfig['waRecipient'],
                        'message' => $msg
                    ]);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: ' . $botConfig['fonnteToken']
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 2); // Fast timeout
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_exec($ch);
                    curl_close($ch);
                }
            }
            // ----------------------------------------
        }

        save_data($file_path, $data);
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID required']);
            break;
        }

        $data = array_filter($data, function($item) use ($id) {
            return $item['id'] != $id;
        });

        save_data($file_path, $data);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
