<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TikTok ES</title>
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





    /* Barra superior */
    .top-bar {
      position: absolute;
      top: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 15px;
      background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);
      font-size: 15px;
      z-index: 10;
    }
    .top-left {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .live-icon {
      width: 24px;
      height: 24px;
    }
    .tabs {
      display: flex;
      gap: 20px;
    }
    .tab {
      cursor: pointer;
      color: #aaa;
    }
    .tab.active {
      color: #fff;
      border-bottom: 2px solid #fff;
      padding-bottom: 2px;
    }
    .search {
      cursor: pointer;
    }
    .search svg {
      width: 22px;
      height: 22px;
      fill: #fff;
    }

    /* Sidebar derecha */
    .sidebar {
      position: absolute;
      right: 10px;
      bottom: 140px;
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
      width: 45px;
      height: 45px;
      border-radius: 50%;
      border: 2px solid #fff;
    }
    .icon span {
      display: block;
      margin-top: 3px;
      font-size: 12px;
    }

    /* Info inferior */
    .bottom-info {
      position: absolute;
      bottom: 110px;
      left: 10px;
      font-size: 14px;
      max-width: 70%;
    }
    .username {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .description {
      font-size: 13px;
    }

    /* Barra de búsqueda inferior */
    .search-bar {
      position: absolute;
      bottom: 65px;
      left: 0;
      width: 100%;
      background: rgba(0,0,0,0.6);
      padding: 8px 12px;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .search-bar input {
      flex: 1;
      background: none;
      border: none;
      outline: none;
      color: #fff;
    }

    /* Barra de navegación inferior */
    .nav-bar {
      position: absolute;
      bottom: 0;
      width: 100%;
      background: #000;
      display: flex;
      justify-content: space-around;
      padding: 8px 0;
      font-size: 12px;
      border-top: 1px solid #222;
    }
    .nav-item {
      text-align: center;
      color: #aaa;
      flex: 1;
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
      font-size: 30px;
      background: #fff;
      color: #000;
      border-radius: 8px;
      padding: 0 10px;
    }
    .badge {
      background: red;
      color: #fff;
      font-size: 10px;
      border-radius: 50%;
      padding: 2px 6px;
      position: absolute;
      top: -5px;
      right: 20%;
    }
    .nav-item-relative {
      position: relative;
    }
  </style>
</head>
<body>

<div class="video-container">

  <!-- Barra superior -->
  <div class="top-bar">
    <div class="top-left">
      <!-- Icono LIVE -->
      <svg class="live-icon" viewBox="0 0 24 24" fill="red" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 5a7 7 0 100 14 7 7 0 000-14zm0-3a10 10 0 100 20 10 10 0 000-20z"/>
        <circle cx="12" cy="12" r="3" fill="white"/>
      </svg>
      <span style="font-weight:bold;">LIVE</span>
    </div>
    <div class="tabs">
      <div class="tab">Siguiendo</div>
      <div class="tab">Tienda</div>
      <div class="tab active">Para ti</div>
    </div>

    <!-- Lupa -->
    <div class="search">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M21.71 20.29l-3.388-3.387A8.943 8.943 0 0019 11a9 9 0 10-9 9 8.943 8.943 0 005.903-2.678l3.387 3.388a1 1 0 001.414-1.414zM4 11a7 7 0 1114 0 7 7 0 01-14 0z"/>
      </svg>
    </div>
  </div>

  <!-- Video -->
  <video autoplay muted loop>
    <source src="img/video.mp4" type="video/mp4">
    Tu navegador no soporta video.
  </video>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="icon"><img src="img/image.jpg" alt="user"></div>
    <div class="icon">❤️<span>1,874</span></div>
    <div class="icon">💬<span>12</span></div>
    <div class="icon">🔖<span>146</span></div>
    <div class="icon">↗️<span>90</span></div>
  </div>

  <!-- Info inferior -->
  <div class="bottom-info">
    <div class="username">Cesar Perez</div>
    <div class="description">#fpy #School #LGBT #Viral #Cesar</div>
  </div>

  <!-- Barra de búsqueda inferior -->
  <div class="search-bar">
    🔍 <input type="text" placeholder="Irvin en tanga venga la alegria...">
  </div>

  <!-- Barra de navegación inferior -->
  <div class="nav-bar">
    <div class="nav-item active">🏠<span>Inicio</span></div>
    <div class="nav-item">👥<span>Amigos</span></div>
    <div class="nav-item plus">＋</div>
    <div class="nav-item nav-item-relative">💬<span>Mensajes</span>
      <div class="badge">17</div>
    </div>
    <div class="nav-item">👤<span>Perfil</span></div>
  </div>
</div>

</body>
</html>
