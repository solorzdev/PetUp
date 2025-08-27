<script>
/**
 * LiveLoc: geolocalización en tiempo real (Leaflet)
 * - Pide permiso al cargar (autoStart).
 * - Dibuja punto (posición) + círculo (precisión).
 * - Si "follow" está activado, centra el mapa mientras te mueves.
 * Requiere HTTPS o localhost.
 */
window.LiveLoc = (function(){
  let map, watchId = null;
  let meMarker = null, accCircle = null;
  let followEl = null, follow = false;
  let recenterZoom = 15;

  function banner(msg) {
    const id = 'geo-banner';
    let el = document.getElementById(id);
    if (!el) {
      el = document.createElement('div');
      el.id = id;
      el.className = 'geo-banner';
      document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.display = 'block';
    clearTimeout(el._t);
    el._t = setTimeout(() => { el.style.display = 'none'; }, 6000);
  }

  function onPosition(pos) {
    const { latitude, longitude, accuracy } = pos.coords;
    const ll = [latitude, longitude];

    if (!meMarker) {
      meMarker = L.circleMarker(ll, {
        radius: 6, color: '#2563EB', fillColor: '#2563EB', fillOpacity: 1
      }).addTo(map);
      accCircle = L.circle(ll, {
        radius: accuracy, color: '#2563EB', weight: 1, fillColor: '#2563EB', fillOpacity: 0.08
      }).addTo(map);
    } else {
      meMarker.setLatLng(ll);
      accCircle.setLatLng(ll).setRadius(accuracy);
    }

    if (follow) {
      map.setView(ll, Math.max(map.getZoom(), recenterZoom), { animate: true });
    }
  }

  function onError(err) {
    banner('Ubicación no disponible' + (err?.message ? `: ${err.message}` : ''));
    stop();
  }

  function start() {
    if (!('geolocation' in navigator)) {
      banner('Tu navegador no soporta geolocalización.');
      return;
    }
    if (watchId !== null) return;
    watchId = navigator.geolocation.watchPosition(onPosition, onError, {
      enableHighAccuracy: true, maximumAge: 5000, timeout: 15000
    });
  }

  function stop() {
    if (watchId !== null) {
      navigator.geolocation.clearWatch(watchId);
      watchId = null;
    }
  }

  function bindFollow(selector) {
    followEl = document.querySelector(selector);
    if (!followEl) return;
    follow = !!followEl.checked;
    followEl.addEventListener('change', e => follow = e.target.checked);
    // si arrastras el mapa, apaga seguir
    map.on('dragstart', () => { follow = false; followEl.checked = false; });
  }

  function init(_map, { autoStart = true, followCheckbox = null, zoom = 15 } = {}) {
    map = _map;
    recenterZoom = zoom;
    if (followCheckbox) bindFollow(followCheckbox);

    if (autoStart) {
      // Fuerza prompt y después inicia watch
      try {
        navigator.geolocation.getCurrentPosition(
          () => start(),
          onError,
          { enableHighAccuracy: true, timeout: 10000 }
        );
      } catch { start(); }
    }

    // Limpieza al salir
    window.addEventListener('beforeunload', stop);
    document.addEventListener('visibilitychange', () => { if (document.hidden) stop(); });
  }

  function getLayers() {
    const arr = [];
    if (meMarker) arr.push(meMarker);
    if (accCircle) arr.push(accCircle);
    return arr;
  }

  return { init, start, stop, getLayers };
})();
</script>

<style>
  .geo-banner{
    position: fixed; left:50%; top:16px; transform:translateX(-50%);
    background:#111827; color:#fff; font-size:.875rem; line-height:1.2;
    padding:10px 14px; border-radius:10px; z-index:1100;
    box-shadow:0 10px 24px rgba(0,0,0,.2);
    display:none;
  }
</style>
