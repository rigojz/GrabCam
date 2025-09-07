<?php
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "👋 <b>Nueva visita</b>\n".
       "📌 IP: $ip\n".
       "🖥️ UA: $ua\n".
       "⏰ Hora: $ts";
send_to_telegram($msg);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Demo ética con Telegram</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="container">
    <h1>Demo ética de geolocalización con Telegram</h1>
    <p class="lead">Esta demo registra tu IP y navegador, y si lo autorizas también tu ubicación. Toda la información se envía a un chat de Telegram controlado por el docente.</p>

    <section class="card">
      <h2>Geolocalización (opcional)</h2>
      <p>Si aceptas, se compartirá tu ubicación aproximada.</p>
      <button id="btnLocate">Compartir mi ubicación</button>
      <div id="locStatus" class="status"></div>
      <div id="locData" class="mono"></div>
    </section>

    <section class="card">
      <h2>Enviar foto (opcional)</h2>
      <p>Puedes tomar una foto con tu cámara y se enviará directamente al chat de Telegram.</p>
      <input type="file" id="photoInput" accept="image/*" capture="environment">
      <div id="photoStatus" class="status"></div>
    </section>
  </main>
  <script src="app.js"></script>
</body>
</html>
