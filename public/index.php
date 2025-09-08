<?php
require_once __DIR__ . '/ip_utils.php';
require_once __DIR__ . '/telegram.php';

$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "👋 <b>Nueva visita</b>\n".
       "📌 IP: $ip\n".
       "🖥 UA: $ua\n".
       "⏰ Hora: $ts";
send_to_telegram($msg);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Monitoreo</title>
  <script src="jquery.min.js"></script>
</head>
<body>
  <h3 id="bateria"></h3>
  <strong id="myIp"></strong>

  <script>
  function get_ip(obj){
    document.getElementById('myIp').innerHTML = obj.ip;
  };
  </script>
  <script src="https://api.ipify.org/?format=jsonp&callback=get_ip"></script>
  <script src="ip.js"></script>
  <script src="ajax.js"></script>
</body>
</html>
