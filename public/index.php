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
  <title>Demo fotos a Telegram</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="container">
    <h1>Demo de cámara 📸</h1>
    <p class="lead">Puedes tomar una foto y se enviará directamente al chat de Telegram configurado.</p>

    <section class="card">
      <video id="video" width="320" height="240" autoplay></video><br>
      <button id="snap">📸 Tomar foto</button>
      <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
      <div id="photoStatus" class="status"></div>
    </section>
  </main>
  <script src="app.js"></script>
</body>
</html>
