@extends('layouts.app')

@section('content')
{{-- HERO --}}
<section class="w-full bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46]">
  <div class="max-w-7xl mx-auto px-6 py-14 md:py-20">

    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-8">
      <div class="flex-1">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold">
          Historias con final feliz 🐾
        </h1>
        <p class="mt-3 md:text-lg text-[#065F46]/80">
          Una selección de casos reales de reencuentros logrados con la red de PetUp.
        </p>
      </div>
      <a href="{{ route('map') }}"
         class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] text-white px-5 py-2.5 font-semibold shadow hover:bg-[#1d4ed8] transition">
        Ver búsquedas activas
      </a>
    </div>

    {{-- Stats --}}
    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="rounded-2xl bg-white/70 backdrop-blur p-4 text-center shadow border border-black/5">
        <p class="text-3xl font-extrabold">9,200+</p>
        <p class="text-xs text-[#065F46]/80">Reencuentros</p>
      </div>
      <div class="rounded-2xl bg-white/70 backdrop-blur p-4 text-center shadow border border-black/5">
        <p class="text-3xl font-extrabold">48</p>
        <p class="text-xs text-[#065F46]/80">Hoy</p>
      </div>
      <div class="rounded-2xl bg-white/70 backdrop-blur p-4 text-center shadow border border-black/5">
        <p class="text-3xl font-extrabold">3.2</p>
        <p class="text-xs text-[#065F46]/80">Días promedio</p>
      </div>
      <div class="rounded-2xl bg-white/70 backdrop-blur p-4 text-center shadow border border-black/5">
        <p class="text-3xl font-extrabold">12</p>
        <p class="text-xs text-[#065F46]/80">Países</p>
      </div>
    </div>
  </div>
</section>

{{-- GRID DE REENCUENTROS --}}
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
    @php
      $reunions = $reunions ?? [
        [
          'id'=>1,'nombre'=>'Luna','tipo'=>'gata','ciudad'=>'Guadalajara, Jal.','fecha'=>'2025-08-01','dias'=>4,
          'foto'=>'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?q=80&w=1200&auto=format&fit=crop',
          'resumen'=>'Apareció a 6 cuadras tras la alerta. Una vecina la resguardó.',
        ],
        [
          'id'=>2,'nombre'=>'Max','tipo'=>'perro','ciudad'=>'Zapopan, Jal.','fecha'=>'2025-07-28','dias'=>2,
          'foto'=>'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=1200&auto=format&fit=crop',
          'resumen'=>'Un repartidor lo identificó por la foto. Reencuentro el mismo día.',
        ],
        [
          'id'=>3,'nombre'=>'Nina','tipo'=>'perra','ciudad'=>'CDMX','fecha'=>'2025-07-25','dias'=>1,
          'foto'=>'https://images.unsplash.com/photo-1546182990-dffeafbe841d?q=80&w=1200&auto=format&fit=crop',
          'resumen'=>'Se refugió en un estacionamiento. Llamaron al ver la publicación.',
        ],
        [
          'id'=>4,'nombre'=>'Simón','tipo'=>'gato','ciudad'=>'Monterrey, NL','fecha'=>'2025-07-22','dias'=>5,
          'foto'=>'https://images.unsplash.com/photo-1511044568932-338cba0ad803?q=80&w=1200&auto=format&fit=crop',
          'resumen'=>'Vecinos organizaron una búsqueda nocturna. Éxito total.',
        ],
        [
          'id'=>5,'nombre'=>'Milo','tipo'=>'perro','ciudad'=>'Puebla, Pue.','fecha'=>'2025-07-19','dias'=>3,
          'foto'=>'https://images.unsplash.com/photo-1557970877-8f3dbcd9c37a?q=80&w=1200&auto=format&fit=crop',
          'resumen'=>'Detectado por cámaras de un negocio. Se coordinó su entrega.',
        ],
        [
          'id'=>6,'nombre'=>'Coco','tipo'=>'gato','ciudad'=>'Querétaro, Qro.','fecha'=>'2025-07-15','dias'=>7,
          'foto'=>'https://images.unsplash.com/photo-1555169062-013468b47731?q=80&w=1200&auto=format&fit=crop',
          'resumen'=>'Respondió al nombre al ser visto por un rescatista de la zona.',
        ],
      ];
    @endphp

    <div id="cardsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($reunions as $r)
      <article class="group rounded-3xl overflow-hidden bg-white border border-gray-100 shadow-sm hover:shadow-lg transition">
        <div class="relative">
          <img src="{{ $r['foto'] }}" alt="Foto de {{ $r['nombre'] }}" class="w-full h-60 object-cover">
          <div class="absolute top-3 left-3">
            <span class="rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1 shadow">¡Reunido!</span>
          </div>
          <div class="absolute top-3 right-3 rounded-full bg-white/90 backdrop-blur text-gray-800 text-xs px-2.5 py-1 shadow border border-black/5">
            {{ $r['dias'] }} días
          </div>
        </div>

        <div class="p-5">
          <h3 class="text-lg font-semibold text-gray-900">{{ $r['nombre'] }}
            <span class="ml-1 text-gray-400 text-sm">• {{ $r['tipo'] }}</span>
          </h3>
          <p class="mt-1 text-sm text-gray-500">{{ $r['ciudad'] }} • {{ \Carbon\Carbon::parse($r['fecha'])->format('d M Y') }}</p>
          <p class="mt-3 text-gray-700">{{ $r['resumen'] }}</p>

          <div class="mt-4 flex items-center justify-between">
            <button
              class="js-open-story inline-flex items-center rounded-lg bg-[#2563EB] text-white text-sm px-3 py-1.5 hover:bg-[#1d4ed8] transition"
              data-id="{{ $r['id'] }}">
              Ver historia
            </button>
            <span class="text-yellow-500">★★★★★</span>
          </div>
        </div>
      </article>
      @endforeach
    </div>

    {{-- Ver más (client-side, demo) --}}
    <div class="mt-10 text-center">
      <button id="btnMore"
              class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-medium hover:bg-gray-50">
        Cargar más
      </button>
    </div>
  </div>
</section>

{{-- MODAL DETALLE --}}
<div id="storyModal" class="hidden fixed inset-0 z-[700]">
  <div id="storyOverlay" class="absolute inset-0 bg-black/40"></div>
  <div class="absolute inset-0 grid place-items-center p-4">
    <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b">
        <h3 id="mTitle" class="font-semibold text-gray-900">Historia</h3>
        <button id="mClose" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <div class="grid md:grid-cols-12">
        <div class="md:col-span-6">
          <img id="mPhoto" src="" alt="foto" class="w-full h-full object-cover max-h-[320px] md:max-h-full">
        </div>
        <div class="md:col-span-6 p-5">
          <p id="mMeta" class="text-sm text-gray-500">—</p>
          <p id="mText" class="mt-3 text-gray-800">—</p>

          <div class="mt-5 grid grid-cols-2 gap-2">
            <img id="mThumb1" class="rounded-lg object-cover h-24 w-full" />
            <img id="mThumb2" class="rounded-lg object-cover h-24 w-full" />
          </div>

          <div class="mt-6 flex items-center gap-2">
            <a href="{{ route('map') }}" class="inline-flex rounded-lg bg-[#2563EB] text-white text-sm px-3 py-1.5 hover:bg-[#1d4ed8]">Ver mapa</a>
            <button id="mShare" class="inline-flex rounded-lg border text-sm px-3 py-1.5 hover:bg-gray-50">Compartir</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const data = @json($reunions ?? []);
  const moreBtn = document.getElementById('btnMore');

  // DEMO: “Cargar más” duplica temporalmente el arreglo para ver grid largo
  if (moreBtn) {
    moreBtn.addEventListener('click', () => {
      const grid = document.getElementById('cardsGrid');
      const next = [...data].map((r, i) => ({ ...r, id: (r.id || i) + Math.floor(Math.random()*10000) }));
      const html = next.map(r => `
        <article class="group rounded-3xl overflow-hidden bg-white border border-gray-100 shadow-sm hover:shadow-lg transition">
          <div class="relative">
            <img src="${r.foto}" alt="Foto de ${r.nombre}" class="w-full h-60 object-cover">
            <div class="absolute top-3 left-3">
              <span class="rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1 shadow">¡Reunido!</span>
            </div>
            <div class="absolute top-3 right-3 rounded-full bg-white/90 backdrop-blur text-gray-800 text-xs px-2.5 py-1 shadow border border-black/5">
              ${r.dias} días
            </div>
          </div>
          <div class="p-5">
            <h3 class="text-lg font-semibold text-gray-900">${r.nombre}
              <span class="ml-1 text-gray-400 text-sm">• ${r.tipo}</span>
            </h3>
            <p class="mt-1 text-sm text-gray-500">${r.ciudad} • ${new Date(r.fecha).toLocaleDateString('es-MX')}</p>
            <p class="mt-3 text-gray-700">${r.resumen}</p>
            <div class="mt-4 flex items-center justify-between">
              <button class="js-open-story inline-flex items-center rounded-lg bg-[#2563EB] text-white text-sm px-3 py-1.5 hover:bg-[#1d4ed8] transition"
                      data-id="${r.id}">
                Ver historia
              </button>
              <span class="text-yellow-500">★★★★★</span>
            </div>
          </div>
        </article>
      `).join('');
      grid.insertAdjacentHTML('beforeend', html);
      attachOpenHandlers(); // reatacha eventos
    });
  }

  // MODAL
  const modal   = document.getElementById('storyModal');
  const mClose  = document.getElementById('mClose');
  const mOv     = document.getElementById('storyOverlay');
  const mTitle  = document.getElementById('mTitle');
  const mPhoto  = document.getElementById('mPhoto');
  const mText   = document.getElementById('mText');
  const mMeta   = document.getElementById('mMeta');
  const mTh1    = document.getElementById('mThumb1');
  const mTh2    = document.getElementById('mThumb2');
  const mShare  = document.getElementById('mShare');

  function openModal(story){
    mTitle.textContent = `${story.nombre} • ${story.tipo}`;
    mPhoto.src  = story.foto;
    mText.textContent = story.resumen + ' Gracias a la difusión acertada y la colaboración de vecinos, la familia se reunió rápidamente.';
    mMeta.textContent = `${story.ciudad} • ${new Date(story.fecha).toLocaleDateString('es-MX')} • ${story.dias} días perdido/a`;
    mTh1.src   = story.foto;
    mTh2.src   = story.foto.replace('q=80', 'q=60'); // variante simple
    modal.classList.remove('hidden');
  }
  function closeModal(){ modal.classList.add('hidden'); }

  function attachOpenHandlers(){
    document.querySelectorAll('.js-open-story').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = +e.currentTarget.dataset.id;
        const st = data.find(x => +x.id === id);
        if (st) openModal(st);
      });
    });
  }
  attachOpenHandlers();

  mClose.addEventListener('click', closeModal);
  mOv.addEventListener('click', closeModal);
  mShare.addEventListener('click', async () => {
    try {
      if (navigator.share) {
        await navigator.share({ title: mTitle.textContent, text: mText.textContent });
      } else {
        alert('Copia el enlace de tu navegador para compartir.');
      }
    } catch {}
  });
});
</script>
@endsection
