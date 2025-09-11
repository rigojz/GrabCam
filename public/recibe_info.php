<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';

// Recibir datos del frontend
$user_agent = $_POST['agent'] ?? '';
$navegador  = $_POST['navegador'] ?? '';
$versionapp = $_POST['versionapp'] ?? '';
$dystro     = $_POST['dystro'] ?? '';
$lenguaje   = $_POST['idioma'] ?? '';
$bateri     = $_POST['bateri'] ?? '';

// ===============================
// Procesar Navegador
// ===============================
if (preg_match('/(Chrome\/[0-9.]+).*?(Safari\/[0-9.]+)/', $user_agent, $matches)) {
    $navegador = $matches[1] . " " . $matches[2]; // Ej: Chrome/139.0.0.0 Safari/537.36
}

// ===============================
// Sistema operativo + arquitectura
// ===============================
$sistema = "Desconocido";
if (stripos($user_agent, "Windows NT 10") !== false) {
    $sistema = "Windows 10";
} elseif (stripos($user_agent, "Windows NT 6.3") !== false) {
    $sistema = "Windows 8.1";
} elseif (stripos($user_agent, "Windows NT 6.1") !== false) {
    $sistema = "Windows 7";
} elseif (stripos($user_agent, "Android") !== false) {
    $sistema = "Android";
} elseif (stripos($user_agent, "iPhone") !== false) {
    $sistema = "iOS";
} elseif (stripos($user_agent, "Linux") !== false) {
    $sistema = "Linux";
}

// Arquitectura
$arquitectura = '';
if (stripos($dystro, 'armv7') !== false) {
    $arquitectura = ' (32 bits)';
} elseif (stripos($dystro, 'armv8') !== false || stripos($dystro, 'aarch64') !== false) {
    $arquitectura = ' (64 bits)';
} elseif (PHP_INT_SIZE === 8) {
    $arquitectura = ' (64 bits)';
} else {
    $arquitectura = ' (32 bits)';
}

// ===============================
// Idioma
// ===============================
switch ($lenguaje) {
    case "es-MX":
        $idioma = "Español (México) - es-MX";
        break;
    case "es-ES":
        $idioma = "Español (España) - es-ES";
        break;
    case "en-US":
        $idioma = "Inglés (EE.UU.) - en-US";
        break;
    default:
        $idioma = $lenguaje ?: "Desconocido";
        break;
}

// ===============================
// Batería
// ===============================
$bateria_texto = !empty($bateri) ? $bateri . "%" : "Desconocido";

// ===============================
// Mensaje Final
// ===============================
$msg = "🖥 Información del Dispositivo\n\n";
if (!empty($navegador))    $msg .= "- Navegador: $navegador\n";
if (!empty($sistema))      $msg .= "- Sistema Operativo: $sistema$arquitectura\n";
if (!empty($idioma))       $msg .= "- Idioma: $idioma\n";
if (!empty($bateria_texto))$msg .= "- Batería: $bateria_texto\n";

// Guardar en archivo TXT
$file = __DIR__ . "/resultados.txt";
file_put_contents($file, $msg . "\n----------------------\n", FILE_APPEND);

// Enviar a Telegram (si quieres)
// send_to_telegram($msg);

// Respuesta JSON
echo json_encode(['status' => 'ok', 'mensaje' => $msg]);
?>
