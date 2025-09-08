<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';

if (empty($_POST['cat'])) {
    http_response_code(400);
    echo json_encode(['status' => 'no_image']);
    exit;
}

$imageData = $_POST['cat'];
$filteredData = substr($imageData, strpos($imageData, ",")+1);
$unencodedData = base64_decode($filteredData);

$tmp_file = tmpfile();
fwrite($tmp_file, $unencodedData);
$meta = stream_get_meta_data($tmp_file);
$tmp_path = $meta['uri'];

send_photo_to_telegram($tmp_path, "📷 Foto recibida desde la demo");

fclose($tmp_file);

echo json_encode(['status' => 'photo_sent']);
