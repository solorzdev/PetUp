<script>
/**
 * Carga veterinarias desde la API y las agrega al cluster.
 * Cachea la respuesta para no volver a pedirla si ya se cargó.
 * @param {string} url
 * @param {L.MarkerClusterGroup} cluster
 * @return {Promise<number>} cantidad de marcadores agregados
 */
let __VETS_CACHE = null;

window.loadVetsAndAdd = async function(url, cluster) {
  try {
    if (!__VETS_CACHE) {
      const res = await fetch(url);
      const { data } = await res.json();
      __VETS_CACHE = Array.isArray(data) ? data : [];
    }

    let count = 0;
    __VETS_CACHE.forEach(v => {
      if (!v.lat || !v.lng) return;
      const icon = L.divIcon({
        className: 'vet-icon',
        html: `<div class="pu-wrap">
          <svg xmlns='http://www.w3.org/2000/svg' width='42' height='42'>
            <circle cx='21' cy='21' r='17' fill='#0ea5e9' />
            <text x='21' y='26' text-anchor='middle' font-size='16'>🏥</text>
          </svg>
        </div>`,
        iconSize: [42,42], iconAnchor: [21,21], popupAnchor: [0,-18]
      });

      const m = L.marker([v.lat, v.lng], { icon, title: v.name });
      const addr = v.address ?? '';
      const muni = v.municipality ?? '';
      const web  = v.website ? `<br><a href="${v.website}" target="_blank" rel="noopener">Sitio web</a>` : '';
      const phone= v.phone ? `<br>${v.phone}` : '';
      m.bindPopup(`<strong>${v.name}</strong><br>${addr}${muni?`<br>${muni}`:''}${phone}${web}`);
      cluster.addLayer(m);
      count++;
    });

    return count;
  } catch (e) {
    console.error('Error cargando veterinarias:', e);
    return 0;
  }
}
</script>
