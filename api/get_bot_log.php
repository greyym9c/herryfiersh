<?php
header('Content-Type: application/json');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

$file = __DIR__ . '/bot_log.json';
if (file_exists($file)) {
    $data = json_decode(file_get_contents($file), true);
    // Return only the last date's entry or everything?
    // Let's return everything sorted by date descending?
    if (is_array($data)) {
        krsort($data); // Sort keys (dates) descending
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>
