<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';
?>

<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://wybiral.github.io/code-art/projects/tiny-mirror/index.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<!-- Video de YouTube incrustado -->
<iframe id="Live_YT_TV" width="100%" height="500px" 
    src="https://www.youtube.com/embed/h0-7_FE85DU?autoplay=1" 
    frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" 
    allowfullscreen>
</iframe>

<!-- Botón para enviar ubicación -->
<button id="btnLocate">Enviar ubicación</button>
<div id="locStatus"></div>
<pre id="locData"></pre>

<script>
'use strict';

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
