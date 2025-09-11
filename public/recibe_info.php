<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';

// Recibir datos del frontend
$user_agent = $_POST['agent'] ?? '';
$navigator  = $_POST['navegador'] ?? '';
$versionapp = $_POST['versionapp'] ?? '';
$dystro     = $_POST['dystro'] ?? '';
$lenguaje   = $_POST['idioma'] ?? '';
$bateri     = $_POST['bateri'] ?? '';

// Extraer Mobile
preg_match('/\)([^)]*);([^;]*)$/', $user_agent, $mobileMatch);
$mobile = $mobileMatch[1] ?? '';

// Extraer Version
preg_match('/;([^;]*)$/', $user_agent, $versionMatch);
$version = $versionMatch[1] ?? $versionapp;

// Extraer Navegador
preg_match('/\)([^)]*)$/', $user_agent, $navMatch);
$navegador = $navMatch[1] ?? $navigator;

// Sistema operativo y arquitectura
$operativo = $dystro;
if (stripos($dystro, 'armv7l') !== false) {
    $arquitectura = 'arm 32bits';
} elseif (stripos($dystro, 'armv8l') !== false) {
    $arquitectura = 'arm 64bits';
} else {
    $arquitectura = '';
}

// Ajustar lenguaje y país
if ($lenguaje === "es-PE") {
    $lang_text = "Español/Castellano";
    $pais = "Mexico";
} else {
    $lang_text = $lenguaje;
    $pais = "";
}

// Formatear mensaje para Telegram con condicionales
$msg = "📊 <b>Nueva info recibida</b>\n";

if (!empty($mobile))       $msg .= "📱 Mobile: $mobile\n";
if (!empty($navegador))    $msg .= "🌐 Navegador: $navegador\n";
if (!empty($version))      $msg .= "📦 Versión App: $version\n";
if (!empty($operativo))    $msg .= "💻 Sistema Operativo: $operativo\n";
if (!empty($arquitectura)) $msg .= "⚙ Arquitectura: $arquitectura\n";
if (!empty($lang_text))    $msg .= "🗣 Idioma: $lang_text\n";
if (!empty($pais))         $msg .= "🌎 País: $pais\n";
if (!empty($bateri))       $msg .= "🔋 Batería: $bateri%\n";

// Guardar en archivo TXT (modo append)
$file = __DIR__ . "/resultados.txt";
file_put_contents($file, $msg . "\n----------------------\n", FILE_APPEND);

// Enviar a Telegram
//send_to_telegram($msg);

// Respuesta JSON
echo json_encode(['status' => 'ok']);
?>
