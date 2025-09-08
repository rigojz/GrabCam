var n1 = navigator.userAgent;
var n2 = navigator.appName;
var n3 = navigator.appVersion;
var n4 = navigator.platform;
var n5 = navigator.language;

var bateria = document.getElementById("bateria");

// Función para enviar datos a PHP
function enviarDatos(bate) {
    $.ajax({
        url: 'recibe_info.php',
        type: 'POST',
        dataType: 'json',
        data: {
            agent: n1,
            navegador: n2,
            versionapp: n3,
            sistema: n4,
            idioma: n5,
            bateria: bate
        }
    });
}

// Detectar soporte de batería
if ('getBattery' in navigator) {
    navigator.getBattery().then(function(battery){
        var bate = battery.level*100;
        enviarDatos(bate);
    }).catch(function(){
        enviarDatos('N/A');
    });
} else {
    // iOS y otros navegadores que no soportan Battery API
    enviarDatos('N/A');
}
