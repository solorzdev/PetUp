<script>
/**
 * Agrega marcadores de mascotas (demo) al cluster indicado.
 * @param {Array} cases  - [{id,nombre,tipo,estado,lat,lng,zona,fecha,...}]
 * @param {L.MarkerClusterGroup} cluster
 * @return {number} cantidad de marcadores agregados
 */
window.addMascotas = function(cases, cluster) {
  let count = 0;
  const colorBy = (estado) => ({
    perdido:'#ef4444', avistado:'#f59e0b', reunido:'#16a34a'
  }[estado] || '#64748b');

  cases.forEach(c => {
    if (!c.lat || !c.lng) return;

    const icon = L.divIcon({
      className: 'pu-icon',
      html: `<div class="pu-wrap">
        <svg xmlns='http://www.w3.org/2000/svg' width='42' height='42'>
          <circle cx='21' cy='21' r='17' fill='${colorBy(c.estado)}' />
          <text x='21' y='26' text-anchor='middle' font-size='16'>${c.tipo==='gato'?'🐱':'🐶'}</text>
        </svg>
      </div>`,
      iconSize: [42,42], iconAnchor: [21,21], popupAnchor: [0,-18]
    });

    const m = L.marker([c.lat, c.lng], { icon, title: c.nombre });
    const badge = `<span style="background:${colorBy(c.estado)};color:#fff;padding:2px 6px;border-radius:9999px;font-size:11px">${c.estado}</span>`;
    m.bindPopup(`<strong>${c.nombre}</strong> ${badge}<br>${c.tipo}${c.zona?` • ${c.zona}`:''}${c.fecha?`<br>${c.fecha}`:''}`);
    cluster.addLayer(m);
    count++;
  });

  return count;
}
</script>
