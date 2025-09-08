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
    }
});
