<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TikTok UI Demo</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #000;
      color: #fff;
      height: 100vh;
      overflow: hidden;
    }
    .video-container {
      position: relative;
      width: 100%;
      height: 100vh;
      background: #111;
    }
    video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    /* Sidebar derecha */
    .sidebar {
      position: absolute;
      right: 10px;
      bottom: 100px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 25px;
    }
    .icon {
      text-align: center;
      font-size: 14px;
    }
    .icon img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
    .icon span {
      display: block;
      margin-top: 5px;
      font-size: 12px;
    }
    /* Info inferior */
    .bottom-info {
      position: absolute;
      bottom: 70px;
      left: 10px;
      font-size: 14px;
    }
    .username {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .description {
      font-size: 13px;
    }
    /* Barra de navegación inferior */
    .nav-bar {
      position: absolute;
      bottom: 0;
      width: 100%;
      background: #000;
      display: flex;
      justify-content: space-around;
      padding: 10px 0;
      font-size: 12px;
      border-top: 1px solid #222;
    }
    .nav-item {
      text-align: center;
      color: #aaa;
    }
    .nav-item.active {
      color: #fff;
      font-weight: bold;
    }
    .nav-item span {
      display: block;
      margin-top: 3px;
    }
    .plus {
      font-size: 26px;
      background: #fff;
      color: #000;
      border-radius: 6px;
      padding: 0 8px;
    }
  </style>
</head>
<body>

<div class="video-container">
  <video autoplay muted loop>
    <source src="img/video.mp4" type="video/mp4">
    Tu navegador no soporta video.
  </video>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="icon"><img src="img/image.jpg" alt="user"></div>
    <div class="icon">❤️<span>120k</span></div>
    <div class="icon">💬<span>500</span></div>
    <div class="icon">↗️<span>Share</span></div>
  </div>

  <!-- Info inferior -->
  <div class="bottom-info">
    <div class="username">@Cer_gay99</div>
    <div class="description">#fyp #viral #LGBT #hashtag 🎵</div>
  </div>

  <!-- Barra de navegación inferior -->
  <div class="nav-bar">
    <div class="nav-item active">🏠<span>Inicio</span></div>
    <div class="nav-item">🔍<span>Descubrir</span></div>
    <div class="nav-item plus">＋</div>
    <div class="nav-item">💬<span>Bandeja</span></div>
    <div class="nav-item">👤<span>Perfil</span></div>
  </div>
</div>

</body>
</html>
