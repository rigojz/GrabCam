const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snapBtn = document.getElementById('snap');
const photoStatus = document.getElementById('photoStatus');

// Acceder a la cámara
navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" }, audio: false })
  .then(stream => {
    video.srcObject = stream;
  })
  .catch(err => {
    photoStatus.textContent = "Error al acceder a la cámara: " + err;
  });

// Tomar foto
snapBtn.addEventListener('click', () => {
  const context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  const imgData = canvas.toDataURL("image/png");

  photoStatus.textContent = "Enviando foto...";

  fetch('photo.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'cat=' + encodeURIComponent(imgData)
  })
  .then(res => res.json())
  .then(out => {
    photoStatus.textContent = "Servidor respondió: " + out.status;
  })
  .catch(err => {
    photoStatus.textContent = "Error: " + err;
  });
});
