<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

if (!isset($_FILES['photo'])) {
    http_response_code(400);
    echo json_encode(['status' => 'no_file']);
    exit;
}

$tmp_name = $_FILES['photo']['tmp_name'];
$file_name = basename($_FILES['photo']['name']);

$token = TELEGRAM_BOT_TOKEN;
$chat_id = TELEGRAM_CHAT_ID;

$url = "https://api.telegram.org/bot$token/sendPhoto";

$post_fields = [
    'chat_id' => $chat_id,
    'caption' => "📷 Foto recibida desde la demo",
    'photo'   => new CURLFile($tmp_name, $_FILES['photo']['type'], $file_name)
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
$output = curl_exec($ch);
curl_close($ch);

echo json_encode(['status' => 'photo_sent', 'telegram_response' => $output]);
