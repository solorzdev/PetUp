@extends('layouts.app')

@section('content')
{{-- Topbar --}}
<div class="w-full bg-[#32BAEA] text-white">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">
    <h1 class="text-2xl md:text-3xl font-extrabold">Mapa de búsquedas</h1>
    <a href="#"
       class="inline-flex items-center gap-2 rounded-full 
              bg-[#FBB03B] text-[#0B1220] px-5 py-2 font-semibold 
              shadow hover:bg-[#e89a17] transition">
      Publicar alerta
    </a>
  </div>
</div>

{{-- ===== CONTENEDOR RELATIVE PARA SUPERPONER CONTROLES ===== --}}
<div x-data="{ open:false, mode:'both' }" class="relative w-full h-[calc(100vh-200px)] select-none">
  {{-- Mapa --}}
  <div id="BuscaDog-map" class="w-full h-full"></div>

  {{-- FAB + menú vertical (inferior-izquierda) --}}
  <div class="absolute bottom-4 left-4 z-[1200] pointer-events-none">
    {{-- Menú (aparece hacia arriba) --}}
    <div
      x-show="open"
      x-transition.origin.bottom.left
      class="mb-3 flex flex-col gap-2 pointer-events-auto"
      @click.outside="open=false"
      style="filter: drop-shadow(0 8px 24px rgba(0,0,0,.2))"
    >
      {{-- Mascotas --}}
      <button
        @click="mode='pets'; $dispatch('layer-change',{ value:'mascotas' }); open=false"
        :class="mode==='pets' ? 'bg-green-600 text-white' : 'bg-white/95 text-gray-800'"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-xl backdrop-blur font-medium"
        aria-label="Mostrar mascotas"
      >
        <span class="text-lg">🐾</span>
        <span>Mascotas</span>
      </button>

      {{-- Veterinarias --}}
      <button
        @click="mode='vets'; $dispatch('layer-change',{ value:'veterinarias' }); open=false"
        :class="mode==='vets' ? 'bg-green-600 text-white' : 'bg-white/95 text-gray-800'"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-xl backdrop-blur font-medium"
        aria-label="Mostrar veterinarias"
      >
        <span class="text-lg">🏥</span>
        <span>Veterinarias</span>
      </button>

      {{-- Ambos --}}
      <button
        @click="mode='both'; $dispatch('layer-change',{ value:'ambos' }); open=false"
        :class="mode==='both' ? 'bg-green-600 text-white' : 'bg-white/95 text-gray-800'"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-xl backdrop-blur font-medium"
        aria-label="Mostrar ambos"
      >
        <span class="text-lg">🔀</span>
        <span>Ambos</span>
      </button>

      {{-- Centrar en mi ubicación --}}
      <button
        @click="window.__centerOnMe?.(); open=false"
        class="inline-flex items-center gap-2 px-3 py-2 rounded-xl font-semibold bg-white/95 text-gray-900 hover:bg-white transition"
        aria-label="Centrar en mi ubicación"
        title="Centrar en mi ubicación"
      >
        <span class="text-lg">📍</span>
        <span>Centrar en mí</span>
      </button>
    </div>

    {{-- Botón flotante principal (FAB) --}}
    <button
      @click="open = !open"
      :class="open ? 'bg-green-700' : 'bg-green-600'"
      class="pointer-events-auto w-12 h-12 rounded-full text-white grid place-items-center shadow-lg active:scale-95 transition"
      aria-label="Abrir opciones"
      title="Opciones de mapa"
    >
      <!-- Ícono menú -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
        <path d="M4 6h16M4 12h12M4 18h8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>
  </div>
</div>


{{-- Leaflet + MarkerCluster (CDN) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
{{-- Alpine para los toggles (si no lo tienes ya cargado globalmente) --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
  // Datos demo de mascotas que envías desde PagesController@map
  window.CASES = @json($cases ?? []);
</script>

{{-- Capas modulares (definen window.addMascotas, window.loadVetsAndAdd, window.LiveLoc) --}}
@include('maps._layer-mascotas')
@include('maps._layer-veterinarias')
@include('maps._live-location')

<script>
document.addEventListener('DOMContentLoaded', async () => {
  // 1) Mapa
  const map = L.map('BuscaDog-map', { zoomControl: true });
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19, attribution: '© OpenStreetMap'
  }).addTo(map);

  // 2) Clusters separados
  const clusterCases = L.markerClusterGroup({ maxClusterRadius: 52 });
  const clusterVets  = L.markerClusterGroup({ maxClusterRadius: 60 });

  // 3) Mascotas (demo)
  const countCases = window.addMascotas(window.CASES, clusterCases);
  if (countCases) clusterCases.addTo(map);

  // 4) Veterinarias (BD)
  const vetsCount = await window.loadVetsAndAdd('/api/v1/veterinaries?limit=2000', clusterVets);
  if (vetsCount) clusterVets.addTo(map);

  // 5) Geoloc en tiempo real
  window.LiveLoc.init(map, { autoStart: true, zoom: 15 });

  // 6) Encaje inicial
  fitToVisible();

  // 7) Escuchar los botones Alpine (evento personalizado)
  document.addEventListener('layer-change', (e) => {
    const v = e.detail?.value || 'ambos';
    if (v === 'mascotas') {
      if (!map.hasLayer(clusterCases)) map.addLayer(clusterCases);
      if (map.hasLayer(clusterVets))   map.removeLayer(clusterVets);
    } else if (v === 'veterinarias') {
      if (map.hasLayer(clusterCases))  map.removeLayer(clusterCases);
      if (!map.hasLayer(clusterVets))  map.addLayer(clusterVets);
    } else { // ambos
      if (!map.hasLayer(clusterCases)) map.addLayer(clusterCases);
      if (!map.hasLayer(clusterVets))  map.addLayer(clusterVets);
    }
    fitToVisible();
  });

  // 8) Función utilitaria: encajar vista a capas visibles
  function fitToVisible() {
    const layers = [];
    if (map.hasLayer(clusterCases) && clusterCases.getLayers().length) layers.push(...clusterCases.getLayers());
    if (map.hasLayer(clusterVets)  && clusterVets.getLayers().length)  layers.push(...clusterVets.getLayers());
    layers.push(...window.LiveLoc.getLayers?.() || []); // ubicación (si existe)

    if (!layers.length) {
      map.setView([20.67, -103.35], 10); // Jalisco aprox
      return;
    }
    const g = L.featureGroup(layers);
    map.fitBounds(g.getBounds().pad(0.2));
  }

  // 9) Función expuesta para botón "Centrar en mí"
  window.__centerOnMe = async function() {
    try {
      // Usar capa LiveLoc si existe
      if (window.LiveLoc?.getLayers) {
        const locLayers = window.LiveLoc.getLayers() || [];
        if (locLayers.length) {
          const fg = L.featureGroup(locLayers);
          map.fitBounds(fg.getBounds().pad(0.2));
          if (map.getZoom() < 15) map.setZoom(15);
          return;
        }
      }
      // Si no hay capa todavía, usar API de geoloc del navegador
      map.locate({ setView: true, maxZoom: 15, enableHighAccuracy: true });
    } catch(e) {
      console.warn('No se pudo centrar en ubicación:', e);
    }
  };
});
</script>


<style>
  #BuscaDog-map { background:#f8fafc; }
  .marker-cluster div{
    background:#065F46; color:#fff; border:2px solid #C7F7DE;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
  }
  .vet-icon svg { filter: drop-shadow(0 4px 12px rgba(0,0,0,.2)); }
</style>
@endsection
