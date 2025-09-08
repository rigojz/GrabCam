$.ajax({
    url: 'ip.php',
    type: 'post',
    data: {
        ip: $('#myIp').html()
    }
});
