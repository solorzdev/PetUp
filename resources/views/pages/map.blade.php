@extends('layouts.app')

@section('content')
{{-- Topbar con gradiente de la marca --}}
<div class="w-full bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46]">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">
    <h1 class="text-2xl md:text-3xl font-extrabold">Mapa de búsquedas</h1>
    <a href="#"
       class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] text-white px-5 py-2 font-semibold shadow hover:bg-[#1d4ed8] transition">
      Publicar alerta
    </a>
  </div>
</div>

<div class="relative">
  {{-- Toggle claro/oscuro (arriba derecha) --}}
  <div class="absolute z-[600] top-4 right-4 flex flex-wrap items-center gap-2">
    <div class="rounded-full bg-white/90 backdrop-blur shadow border border-black/5 p-1">
      <button id="t-light" class="px-3 py-1.5 text-sm rounded-full font-medium bg-[#065F46] text-white">Claro</button>
      <button id="t-dark"  class="px-3 py-1.5 text-sm rounded-full font-medium text-[#065F46]">Oscuro</button>
    </div>
  </div>

  {{-- Contenedor del mapa --}}
  <div id="petup-map" class="w-full h-[calc(100vh-180px)]"></div>

  <!-- Dock de controles: dentro del mapa, abajo-izquierda -->
  <div class="absolute inset-0 z-[650] pointer-events-none">
    <div class="absolute bottom-4 left-4 flex flex-col gap-2 pointer-events-auto">
      <button id="btn-live"   class="ctrl-btn flex items-center gap-2 rounded-full bg-white/95 text-gray-800 border border-black/5 shadow px-4 py-2 hover:bg-white transition">▶ <span>En vivo</span></button>
      <button id="btn-follow" class="ctrl-btn flex items-center gap-2 rounded-full bg-white/95 text-gray-800 border border-black/5 shadow px-4 py-2 hover:bg-white transition">🧭 <span>Seguir</span></button>
      <button id="btn-center" class="ctrl-btn flex items-center gap-2 rounded-full bg-white/95 text-gray-800 border border-black/5 shadow px-4 py-2 hover:bg-white transition">🎯 <span>Centrar</span></button>
      <button id="btn-fit"    class="ctrl-btn flex items-center gap-2 rounded-full bg-white/95 text-gray-800 border border-black/5 shadow px-4 py-2 hover:bg-white transition">⤢ <span>Todos</span></button>
    </div>
  </div>

  {{-- Bottom sheet para detalle de caso (click en marcador) --}}
  <div id="sheet" class="pointer-events-none fixed inset-x-0 bottom-4 z-[600] flex justify-center">
    <div id="sheetCard" class="hidden pointer-events-auto w-[calc(100%-2rem)] md:max-w-xl rounded-2xl bg-white/95 backdrop-blur shadow-xl border border-black/5 p-4"></div>
  </div>

  {{-- Banner de permisos --}}
  <div id="geoBanner" class="hidden absolute top-4 left-1/2 -translate-x-1/2 z-[650]
              rounded-xl bg-white/95 backdrop-blur border border-black/10 shadow px-4 py-2 text-sm text-gray-700">
    Para ver tu ubicación, permite el acceso en el navegador (HTTPS obligatorio).
    <button id="btn-geo-help" class="ml-3 underline text-[#065F46]">¿Cómo habilitar?</button>
  </div>

  {{-- Modal de ayuda para habilitar ubicación --}}
  <div id="geoHelpModal" class="hidden fixed inset-0 z-[700]">
    <div id="geoHelpOverlay" class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 grid place-items-center p-4">
      <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between px-5 py-4 border-b">
          <h3 class="font-semibold text-gray-900">Habilitar ubicación en tu navegador</h3>
          <button id="geoHelpClose" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div class="px-5 py-4 text-sm text-gray-700 space-y-4">
          <div>
            <p class="font-semibold">Chrome (Android / Desktop)</p>
            <ol class="list-decimal ml-5">
              <li>Toca el candado en la barra de direcciones.</li>
              <li>Permisos &rarr; <strong>Ubicación</strong> &rarr; Permitir.</li>
              <li>Recarga la página.</li>
            </ol>
          </div>
          <div>
            <p class="font-semibold">Safari (iPhone / iPad)</p>
            <ol class="list-decimal ml-5">
              <li>Ve a Ajustes &rarr; Safari &rarr; Localización.</li>
              <li>Selecciona <strong>Preguntar</strong> o <strong>Permitir</strong>.</li>
              <li>Regresa a la página y acepta el permiso.</li>
            </ol>
          </div>
          <div>
            <p class="font-semibold">Safari (Mac)</p>
            <ol class="list-decimal ml-5">
              <li>Safari &rarr; Preferencias &rarr; Sitios Web &rarr; Localización.</li>
              <li>Busca este sitio y marca <strong>Permitir</strong>.</li>
              <li>Recarga la página.</li>
            </ol>
          </div>
          <div class="text-xs text-gray-500">
            Nota: La geolocalización requiere <strong>HTTPS</strong> (o <code>localhost</code> en desarrollo).
          </div>
        </div>
        <div class="px-5 py-4 border-t flex justify-end">
          <button id="geoHelpOk" class="rounded-lg bg-[#065F46] text-white px-4 py-2 font-medium">Entendido</button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Leaflet + MarkerCluster (CDN) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const cases = @json($cases ?? []);

  // ====== Mapa + capas base claro/oscuro ======
  const map = L.map('petup-map', { zoomControl: true });
  const light = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { maxZoom: 20, attribution:'&copy; OpenStreetMap &copy; CARTO' });
  const dark  = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',  { maxZoom: 20, attribution:'&copy; OpenStreetMap &copy; CARTO' });
  light.addTo(map);

  // ====== Clusters ======
  const cluster = L.markerClusterGroup({
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    maxClusterRadius: 52,
  }).addTo(map);

  // ====== Utilidades UI ======
  const bLight = document.getElementById('t-light');
  const bDark  = document.getElementById('t-dark');
  bLight.addEventListener('click', () => { map.removeLayer(dark); light.addTo(map); bLight.classList.add('bg-[#065F46]','text-white'); bDark.classList.remove('bg-[#065F46]','text-white'); });
  bDark .addEventListener('click', () => { map.removeLayer(light); dark .addTo(map);  bDark .classList.add('bg-[#065F46]','text-white');  bLight.classList.remove('bg-[#065F46]','text-white'); });

  const geoBanner     = document.getElementById('geoBanner');
  const geoHelpModal  = document.getElementById('geoHelpModal');
  const geoHelpOpen   = document.getElementById('btn-geo-help');
  const geoHelpClose  = document.getElementById('geoHelpClose');
  const geoHelpOk     = document.getElementById('geoHelpOk');
  const geoHelpOverlay= document.getElementById('geoHelpOverlay');

  function showGeoBanner(msg='Para ver tu ubicación, permite el acceso en el navegador (HTTPS obligatorio).'){
    geoBanner.textContent = msg + ' ';
    const btn = document.createElement('button');
    btn.id = 'btn-geo-help';
    btn.className = 'ml-1 underline text-[#065F46]';
    btn.textContent = '¿Cómo habilitar?';
    btn.addEventListener('click', openHelp);
    geoBanner.appendChild(btn);

    geoBanner.classList.remove('hidden');
    clearTimeout(showGeoBanner._t);
    showGeoBanner._t = setTimeout(()=> geoBanner.classList.add('hidden'), 7000);
  }

  function openHelp(){ geoHelpModal.classList.remove('hidden'); }
  function closeHelp(){ geoHelpModal.classList.add('hidden'); }

  geoHelpOpen?.addEventListener('click', openHelp);
  geoHelpClose?.addEventListener('click', closeHelp);
  geoHelpOk?.addEventListener('click', closeHelp);
  geoHelpOverlay?.addEventListener('click', closeHelp);

  // ====== Colores por estado y marcadores ======
  const colorBy = (estado) => ({
    perdido: '#ef4444',   // red-500
    avistado: '#f59e0b',  // amber-500
    reunido:  '#16a34a',  // green-600
  }[estado] || '#64748b');

  function buildIcon(emoji, bg, pulse=false){
    const html =
      `<div class="pu-wrap ${pulse ? 'pu-pulse' : ''}" style="--c:${bg}">
        <svg xmlns='http://www.w3.org/2000/svg' width='48' height='48'>
          <defs><filter id="s" x="-20%" y="-20%" width="140%" height="140%"><feDropShadow dx="0" dy="3" stdDeviation="3" flood-opacity=".25"/></filter></defs>
          <circle cx='24' cy='24' r='17' fill='${bg}' filter='url(#s)' />
          <text x='24' y='28' text-anchor='middle' font-size='18'>${emoji}</text>
        </svg>
      </div>`;
    return L.divIcon({ className:'pu-icon', html, iconSize:[48,48], iconAnchor:[24,24], popupAnchor:[0,-22] });
  }

  const fotoFor = (tipo) => (tipo === 'gato' ? 'https://placekitten.com/320/200' : 'https://placedog.net/320/200');
  const badge = (estado) => `<span class="inline-block text-white text-[11px] px-2 py-1 rounded-full capitalize" style="background:${colorBy(estado)}">${estado}</span>`;

  const markers = [];
  cases.forEach(c => {
    const icon = buildIcon(c.tipo === 'gato' ? '🐱':'🐶', colorBy(c.estado), c.estado==='perdido');
    const marker = L.marker([c.lat, c.lng], { icon });
    marker.on('click', () => openSheet(c));
    cluster.addLayer(marker);
    markers.push(marker);
  });

  if (markers.length) {
    const g = L.featureGroup(markers);
    map.fitBounds(g.getBounds().pad(0.2));
  } else {
    map.setView([20.675, -103.37], 12);
  }

  // ====== Bottom sheet ======
  const sheetCard = document.getElementById('sheetCard');
  function openSheet(c){
    sheetCard.innerHTML = `
      <div class="flex gap-3">
        <img src="${c.foto ?? fotoFor(c.tipo)}" class="w-28 h-28 rounded-xl object-cover shadow-sm" alt="${c.nombre}">
        <div class="min-w-0">
          <div class="flex items-center justify-between gap-2">
            <h3 class="font-semibold text-gray-900 truncate">${c.nombre}</h3>
            ${badge(c.estado)}
          </div>
          <p class="text-xs text-gray-500 mt-0.5">${c.tipo} • ${c.zona} • ${c.fecha}</p>
          <div class="mt-3 flex flex-wrap gap-2">
            <a href="#" class="inline-flex items-center rounded-lg bg-[#2563EB] text-white text-sm px-3 py-1.5 hover:bg-[#1d4ed8]">Ver alerta</a>
            <button class="inline-flex items-center rounded-lg border text-sm px-3 py-1.5 hover:bg-gray-50">Reportar</button>
          </div>
        </div>
      </div>`;
    sheetCard.classList.remove('hidden');
  }

  // ====== Dock: En vivo / Seguir / Centrar / Todos ======
  const liveBtn   = document.getElementById('btn-live');
  const followBtn = document.getElementById('btn-follow');
  const centerBtn = document.getElementById('btn-center');
  const fitBtn    = document.getElementById('btn-fit');

  function setActive(btn, on){
    btn.classList.toggle('active', on); // usamos una sola clase y lo resolvemos en CSS
  }


  function liveLabel(active){ liveBtn.innerHTML = active ? '⏹ <span>En vivo</span>' : '▶ <span>En vivo</span>'; }

  const LAST_KEY = 'petup:lastpos';
  function saveLast(ll, acc){ try { localStorage.setItem(LAST_KEY, JSON.stringify({ ll, acc, ts: Date.now() })); } catch {} }
  function loadLast(){ try { const j = localStorage.getItem(LAST_KEY); return j ? JSON.parse(j) : null; } catch { return null; } }

  let watchId = null;
  let meMarker = null;
  let meAccuracy = null;
  let follow = true;
  let meTrack = null;

  function makeMeIcon() {
    return L.divIcon({
      className: 'me-dot',
      html: `
        <div class="me-wrap">
          <div class="me-arrow"></div>
          <div class="me-pulse"></div>
          <div class="me-core"></div>
          <div class="me-speed" aria-label="velocidad"></div>
        </div>
      `,
      iconSize: [28, 28],
      iconAnchor: [14, 14]
    });
  }
  function bearingToCardinal(deg){
    if (!Number.isFinite(deg)) return '';
    const dirs = ['N','NE','E','SE','S','SW','W','NW'];
    return dirs[Math.round(deg / 45) % 8];
  }

  async function ensureGeoPermission() {
    if (!('geolocation' in navigator)) { showGeoBanner('Tu navegador no soporta geolocalización.'); return false; }
    if (!('permissions' in navigator)) return true;
    try {
      const status = await navigator.permissions.query({ name: 'geolocation' });
      if (status.state === 'denied') { showGeoBanner('La ubicación está bloqueada. Actívala en ajustes del navegador.'); return false; }
      return true;
    } catch { return true; }
  }

  function startLive(){
    if (watchId !== null) return;
    setActive(liveBtn, true); liveLabel(true);
    follow = true; setActive(followBtn, true);

    meTrack = L.polyline([], { color:'#2563EB', weight:3, opacity:.7 }).addTo(map);

    watchId = navigator.geolocation.watchPosition(
      pos => {
        const { latitude, longitude, accuracy, heading, speed } = pos.coords;
        const ll = [latitude, longitude];

        if (!meMarker) {
          meMarker   = L.marker(ll, { icon: makeMeIcon() }).addTo(map);
          meAccuracy = L.circle(ll, { radius: accuracy, color:'#3b82f6', weight:1, fillColor:'#3b82f6', fillOpacity:.08 }).addTo(map);
          map.setView(ll, Math.max(map.getZoom(), 15), { animate: true });
        } else {
          meMarker.setLatLng(ll);
          meAccuracy.setLatLng(ll).setRadius(accuracy);
        }

        meTrack.addLatLng(ll);
        saveLast(ll, accuracy);

        // Rumbo + velocidad
        const el = meMarker.getElement();
        if (el) {
          const kmh = Number.isFinite(speed) ? (speed * 3.6) : 0;
          const hasHeading = Number.isFinite(heading) && kmh > 1.5;
          el.style.setProperty('--h', `${hasHeading ? heading : 0}deg`);
          el.classList.toggle('is-moving', !!hasHeading);
          const sp = el.querySelector('.me-speed');
          if (sp) {
            if (kmh > 0.5) {
              const dir = hasHeading ? `${bearingToCardinal(heading)} • ` : '';
              sp.textContent = `${dir}${kmh.toFixed(1)} km/h`;
              sp.classList.remove('hidden');
            } else {
              sp.classList.add('hidden');
            }
          }
        }

        if (follow) map.setView(ll, map.getZoom() < 15 ? 15 : map.getZoom(), { animate: true });
      },
      err => {
        stopLive();
        showGeoBanner('No pudimos obtener tu ubicación (' + err.message + ').');
      },
      { enableHighAccuracy: true, maximumAge: 5000, timeout: 15000 }
    );
  }

  function stopLive(){
    if (watchId !== null) { navigator.geolocation.clearWatch(watchId); watchId = null; }
    if (meTrack)    { map.removeLayer(meTrack); meTrack = null; }
    setActive(liveBtn, false); liveLabel(false);
    // Mantenemos meMarker/meAccuracy para conservar la última ubicación visible
  }

  // Botones dock
  liveBtn.addEventListener('click', async () => {
    if (watchId === null) { if (!await ensureGeoPermission()) return; startLive(); }
    else { stopLive(); }
  });
  followBtn.addEventListener('click', () => { follow = !follow; setActive(followBtn, follow); });
  centerBtn.addEventListener('click', () => {
    if (meMarker) {
      const ll = meMarker.getLatLng();
      map.setView(ll, Math.max(map.getZoom(), 15), { animate: true });
    } else {
      map.locate({ setView:true, maxZoom:16 });
    }
  });
  fitBtn.addEventListener('click', () => {
    const layers = [];
    if (cluster.getLayers().length) layers.push(...cluster.getLayers());
    if (meMarker) layers.push(meMarker);
    if (!layers.length) return;
    const g = L.featureGroup(layers); map.fitBounds(g.getBounds().pad(0.2));
  });

  map.on('locationerror', (ev) => {
    if (ev.code === 1) showGeoBanner('Permiso denegado. Habilítalo en la configuración del navegador.');
    else showGeoBanner('No pudimos obtener tu ubicación. Intenta de nuevo.');
  });

  // Si el usuario arrastra el mapa, desactiva "Seguir"
  map.on('dragstart', () => { follow = false; setActive(followBtn, false); });

  // Pintar última ubicación guardada y autoiniciar si ya hay permiso
  const last = loadLast();
  if (last && last.ll) {
    meMarker   = L.marker(last.ll, { icon: makeMeIcon() }).addTo(map);
    meAccuracy = L.circle(last.ll, { radius: last.acc || 30, color:'#3b82f6', weight:1, fillColor:'#3b82f6', fillOpacity:.08 }).addTo(map);
  }
  if ('permissions' in navigator) {
    navigator.permissions.query({ name:'geolocation' }).then(s => {
      if (s.state === 'granted') startLive(); // arranca solo si ya diste permiso
      if (s.state === 'denied')  showGeoBanner('La ubicación está bloqueada. Actívala en ajustes del navegador.');
    });
  }

  // Limpieza al salir/ocultar
  window.addEventListener('beforeunload', stopLive);
  document.addEventListener('visibilitychange', () => { if (document.hidden) stopLive(); });
});
</script>

<style>
  /* Fondo del mapa y clusters con estilo de marca */
  #petup-map { background:#f8fafc; }
  .marker-cluster div{
    background:#065F46; color:#fff; border:2px solid #C7F7DE;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
  }

  /* Marcadores por estado (pulso usa var(--c)) */
  .pu-wrap{ position:relative; width:48px; height:48px; }
  .pu-pulse::after{
    content:""; position:absolute; inset:0; border-radius:9999px;
    box-shadow:0 0 0 0 color-mix(in srgb, var(--c) 45%, transparent);
    animation: pu 2s ease-out infinite;
  }
  @keyframes pu{ 0%{transform:scale(1);opacity:.6} 70%{transform:scale(1.8);opacity:0} 100%{transform:scale(1.8);opacity:0} }

  /* Ubicación en vivo: flecha, pulso, badge de velocidad */
  .me-wrap { position:relative; width:28px; height:28px; }
  .me-arrow{
    position:absolute; top:-8px; left:50%; transform: translateX(-50%) rotate(var(--h,0deg));
    width:0; height:0;
    border-left:6px solid transparent; border-right:6px solid transparent; border-bottom:10px solid #3b82f6;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,.25));
    opacity:0; transition:opacity .2s;
  }
  .is-moving .me-arrow{ opacity:1; }
  .me-core{
    position:absolute; inset:5px; background:#3b82f6; border:2px solid #fff; border-radius:9999px;
    box-shadow:0 2px 8px rgba(0,0,0,.25);
  }
  .me-pulse{
    position:absolute; inset:0; border-radius:9999px; background: rgba(59,130,246,.25);
    animation: mepulse 1.8s ease-out infinite;
  }
  @keyframes mepulse{ 0%{transform:scale(1);opacity:.55} 80%{transform:scale(2.1);opacity:0} 100%{transform:scale(2.1);opacity:0} }
  .me-speed{
    position:absolute; top:32px; left:50%; transform:translateX(-50%);
    background: rgba(17,24,39,.9); color:#fff; font-size:.65rem; line-height:1;
    padding: 4px 6px; border-radius:8px; white-space:nowrap; box-shadow:0 8px 20px rgba(0,0,0,.15);
  }

  /* Botón base ya viene de Tailwind (bg white, etc). Solo definimos el estado activo */
  .ctrl-btn.active{
    background: #C7F7DE;        /* verde claro, mismo de tu navbar */
    color: #111827;             /* texto negro/gris muy oscuro */
    border-color: #065F46;      /* borde acorde a la marca */
    box-shadow: 0 10px 24px rgba(6,95,70,.18);
  }
  .ctrl-btn.active span{ color:#111827; } /* por si el ícono/label heredan distinto */

</style>
@endsection
