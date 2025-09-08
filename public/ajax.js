navigator.getBattery().then(function(battery){
    $.ajax({
        url: 'device_info.php',
        type: 'post',
        dataType: 'json',
        data: {
            agent: navigator.userAgent,
            navegador: navigator.appName,
            versionapp: navigator.appVersion,
            dystro: navigator.platform,
            idioma: navigator.language,
            bateri: battery.level * 100
        }
    });
});
