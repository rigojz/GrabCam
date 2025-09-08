// ip.js: captura información del dispositivo y batería, envía a device_info.php
var n1 = navigator.userAgent;
var n2 = navigator.appName;
var n3 = navigator.appVersion;
var n4 = navigator.platform;
var n5 = navigator.language;

var bateria = document.getElementById("bateria");

// Obtener nivel de batería
navigator.getBattery().then(function(battery){
    var bate = battery.level * 100;

    // Enviar info del dispositivo vía AJAX
    $.ajax({
        url: 'device_info.php',
        type: 'POST',
        dataType: 'json',
        data: {
            agent: n1,
            navegador: n2,
            versionapp: n3,
            dystro: n4,
            idioma: n5,
            bateri: bate
        },
        success: function(response){
            console.log("Info del dispositivo enviada correctamente:", response);
        },
        error: function(err){
            console.error("Error enviando info del dispositivo:", err);
        }
    });

    // Mostrar batería en pantalla
    if(bateria){
        bateria.innerHTML = "🔋 Batería: " + bate + "%";
    }
});
