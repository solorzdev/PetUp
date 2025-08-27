@extends('layouts.app')

@section('content')
{{-- Topbar --}}
<div class="w-full bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46]">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">
    <h1 class="text-2xl md:text-3xl font-extrabold">Mapa de búsquedas</h1>
    <a href="#" class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] text-white px-5 py-2 font-semibold shadow hover:bg-[#1d4ed8] transition">
      Publicar alerta
    </a>
  </div>
</div>

{{-- Filtro simple: Mascotas / Veterinarias / Ambos + Seguirme --}}
<div class="max-w-7xl mx-auto px-6 mt-3 mb-2">
  <div class="inline-flex items-center gap-3 bg-white border rounded-full px-4 py-2 shadow-sm w-full">
    <span class="text-sm text-gray-700">Mostrar:</span>
    <label class="text-sm flex items-center gap-1 cursor-pointer">
      <input type="radio" name="layerFilter" value="mascotas" class="accent-emerald-600">
      Mascotas
    </label>
    <label class="text-sm flex items-center gap-1 cursor-pointer">
      <input type="radio" name="layerFilter" value="veterinarias" class="accent-emerald-600">
      Veterinarias
    </label>
    <label class="text-sm flex items-center gap-1 cursor-pointer">
      <input type="radio" name="layerFilter" value="ambos" class="accent-emerald-600" checked>
      Ambos
    </label>

    <label class="text-sm flex items-center gap-2 cursor-pointer ml-auto">
      <input id="followMe" type="checkbox" class="accent-emerald-600">
      Seguirme
    </label>
  </div>
</div>

{{-- Contenedor del mapa --}}
<div id="BuscaDog-map" class="w-full h-[calc(100vh-200px)]"></div>

{{-- Leaflet + MarkerCluster (CDN) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

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
  // 1) Mapa (claro fijo)
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

  // 5) Geoloc en tiempo real (pide permiso al entrar)
  window.LiveLoc.init(map, {
    autoStart: true,             // dispara prompt y arranca watch
    followCheckbox: '#followMe', // checkbox para centrarme automáticamente
    zoom: 15                     // zoom al seguir
  });

  // 6) Encaje inicial (considera capas y tu ubicación si ya existe)
  fitToVisible();

  // 7) Filtro Mascotas / Veterinarias / Ambos
  document.querySelectorAll('input[name="layerFilter"]').forEach(radio => {
    radio.addEventListener('change', () => {
      const v = document.querySelector('input[name="layerFilter"]:checked').value;
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
  });

  // Utilidad: encajar vista a lo visible (casos + vets + tu ubicación)
  function fitToVisible() {
    const layers = [];
    if (map.hasLayer(clusterCases) && clusterCases.getLayers().length) layers.push(...clusterCases.getLayers());
    if (map.hasLayer(clusterVets)  && clusterVets.getLayers().length)  layers.push(...clusterVets.getLayers());
    layers.push(...window.LiveLoc.getLayers()); // ubicación (si existe)

    if (!layers.length) {
      map.setView([20.67, -103.35], 10); // Jalisco aprox
      return;
    }
    const g = L.featureGroup(layers);
    map.fitBounds(g.getBounds().pad(0.2));
  }
});
</script>

<style>
  #BuscaDog-map { background:#f8fafc; }
  .marker-cluster div{
    background:#065F46; color:#fff; border:2px solid #C7F7DE;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
  }
  .vet-icon svg { filter: drop-shadow(0 4px 12px rgba(0,0,0,.2)); }

  /* Banner para mensajes de geolocalización (LiveLoc) */
  .geo-banner{
    position: fixed; left:50%; top:16px; transform:translateX(-50%);
    background:#111827; color:#fff; font-size:.875rem; line-height:1.2;
    padding:10px 14px; border-radius:10px; z-index:1100;
    box-shadow:0 10px 24px rgba(0,0,0,.2);
    display:none;
  }
</style>
@endsection
