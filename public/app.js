const btn = document.getElementById('btnLocate');
const statusEl = document.getElementById('locStatus');
const dataEl = document.getElementById('locData');

function setStatus(msg) {
  statusEl.textContent = msg;
}

function showData(obj) {
  dataEl.textContent = JSON.stringify(obj, null, 2);
}

btn?.addEventListener('click', () => {
  if (!('geolocation' in navigator)) {
    setStatus('Geolocalización no disponible.');
    return;
  }
  setStatus('Solicitando permiso...');
  navigator.geolocation.getCurrentPosition(async (pos) => {
    const { latitude, longitude, accuracy } = pos.coords;
    setStatus('Ubicación obtenida, enviando a Telegram...');
    showData({ latitude, longitude, accuracy });
    try {
      const res = await fetch('location.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ latitude, longitude, accuracy })
      });
      const out = await res.json();
      setStatus('Servidor respondió: ' + out.status);
    } catch (e) {
      setStatus('Error: ' + e.message);
    }
  }, (err) => {
    setStatus('Error: ' + err.message);
  }, { enableHighAccuracy: false, timeout: 10000 });
});

// Photo upload
const photoInput = document.getElementById('photoInput');
const photoStatus = document.getElementById('photoStatus');

photoInput?.addEventListener('change', async () => {
  const file = photoInput.files[0];
  if (!file) return;

  photoStatus.textContent = 'Enviando foto a Telegram...';

  const formData = new FormData();
  formData.append('photo', file);

  try {
    const res = await fetch('photo.php', {
      method: 'POST',
      body: formData
    });
    const out = await res.json();
    photoStatus.textContent = 'Servidor respondió: ' + out.status;
  } catch (e) {
    photoStatus.textContent = 'Error: ' + e.message;
  }
});
