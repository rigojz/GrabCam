<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#fff">
  <link rel="stylesheet" href="style.css">
  <script src="jquery.min.js"></script>
  <title>Demo Info</title>
</head>
<body>
  <h3 id="bateria"></h3>

  <strong id="myIp"></strong>

  <script>
  function get_ip(obj){
      document.getElementById('myIp').innerHTML = obj.ip;
  };
  </script>

  <script type="text/javascript" src="https://api.ipify.org/?format=jsonp&callback=get_ip"></script>
  <script src="ip.js"></script>
  <script src="ajax.js"></script>
</body>
</html>
