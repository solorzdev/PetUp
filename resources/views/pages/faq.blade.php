@extends('layouts.app')

@section('content')
{{-- =================== HERO =================== --}}

<section class="relative w-full overflow-hidden bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46]">
  <!-- Contenido centrado y alto generoso -->
  <div class="max-w-6xl mx-auto px-6 py-24 md:py-40 min-h-[50vh] grid place-items-center text-center">
    <div>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight tracking-tight">
        Preguntas frecuentes
      </h1>
      <p class="mt-5 text-lg md:text-2xl text-[#065F46]/80 font-medium">
        Respuestas rápidas sobre cómo usar PetUp, pagos y el mapa.
      </p>
    </div>
  </div>

  <!-- Perrito izquierdo -->
  <div class="hidden md:block absolute left-8 xl:left-12 top-1/2 -translate-y-1/2">
    <div class="w-40 h-40 xl:w-48 xl:h-48 grid place-items-center rounded-3xl bg-white/85 shadow-2xl ring-1 ring-black/5 rotate-[-6deg]">
      <!-- Si prefieres un SVG/PNG local, sustituye el span por <img src="/images/icons/dog-left.svg" class="w-16 xl:w-20" alt="perrito"> -->
      <span class="text-6xl xl:text-7xl bob">🐶</span>
    </div>
  </div>

  <!-- Perrito derecho -->
  <div class="hidden md:block absolute right-8 xl:right-12 top-1/2 -translate-y-1/2">
    <div class="w-40 h-40 xl:w-48 xl:h-48 grid place-items-center rounded-3xl bg-white/85 shadow-2xl ring-1 ring-black/5 rotate-[6deg]">
      <!-- <img src="/images/icons/dog-right.svg" class="w-16 xl:w-20" alt="perrito"> -->
      <span class="text-6xl xl:text-7xl bob">🐕</span>
    </div>
  </div>
</section>

<style>
  /* oscilación suave de los perritos */
  .bob { animation: bob 3.6s ease-in-out infinite; display:inline-block; }
  @keyframes bob { 0%,100% { transform: translateY(0) } 50% { transform: translateY(-8px) } }
</style>


{{-- =================== CATEGORÍAS =================== --}}
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-6 py-10">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
      @php
        $cats = [
          ['id'=>'publicar','title'=>'Publicar alerta','desc'=>'Crea tu anuncio'],
          ['id'=>'pagos','title'=>'Pagos y planes','desc'=>'Precios y facturación'],
          ['id'=>'mapa','title'=>'Mapa y reportes','desc'=>'Cómo funciona'],
          ['id'=>'cuenta','title'=>'Cuenta y soporte','desc'=>'Acceso y ayuda'],
        ];
      @endphp
      @foreach($cats as $c)
        <a href="#{{ $c['id'] }}"
           class="rounded-2xl border border-[#065F46]/20 bg-white hover:bg-[#DCFCE7]/40 transition p-5 block">
          <h3 class="font-semibold text-[#065F46]">{{ $c['title'] }}</h3>
          <p class="text-sm text-gray-600">{{ $c['desc'] }}</p>
        </a>
      @endforeach
    </div>
  </div>
</section>

{{-- =================== LISTA DE FAQS =================== --}}
@php
  $faqs = [
    'publicar' => [
      ['q'=>'¿Cómo publico una alerta de mi mascota?','a'=>'Ve a “Crear alerta”, sube 2 a 5 fotos claras, describe señas particulares y marca en el mapa la última ubicación. Publica y comparte el enlace.'],
      ['q'=>'¿Qué fotos funcionan mejor?','a'=>'Primer plano del rostro, cuerpo completo y alguna con accesorio (collar, arnés). Evita fotos oscuras o borrosas.'],
      ['q'=>'¿Puedo editar mi alerta después?','a'=>'Sí. Desde “Mis alertas” puedes actualizar texto, fotos y zona. Los cambios se reflejan en segundos.'],
    ],
    'pagos' => [
      ['q'=>'¿PetUp es gratis?','a'=>'La publicación básica es gratuita en esta demo. Ofrecemos planes de difusión con mayor alcance y reportes priorizados.'],
      ['q'=>'¿Qué medios de pago aceptan?','a'=>'Tarjeta de crédito/débito. En el lanzamiento consideraremos transferencias locales.'],
      ['q'=>'¿Puedo pedir factura?','a'=>'Sí, al completar el pago podrás cargar datos fiscales para generar tu comprobante.'],
    ],
    'mapa' => [
      ['q'=>'¿Cómo funciona el mapa colaborativo?','a'=>'Concentra reportes por zona. Puedes filtrar por especie, fecha y radio de búsqueda. Próximamente: notificaciones por colonia.'],
      ['q'=>'¿Puedo reportar un avistamiento?','a'=>'Sí, desde cualquier alerta puedes presionar “Reportar avistamiento”, adjuntar foto y ubicación aproximada.'],
      ['q'=>'¿Cada cuánto se actualiza?','a'=>'En tiempo casi real. Los nuevos reportes aparecen al instante y los filtros no requieren recargar la página.'],
    ],
    'cuenta' => [
      ['q'=>'Olvidé mi contraseña','a'=>'Usa “Recuperar acceso” para recibir un correo de restablecimiento.'],
      ['q'=>'¿Cómo contacto soporte?','a'=>'Escríbenos desde el botón “Ayuda” o al correo soporte@petup.demo. Respondemos en horario laboral.'],
      ['q'=>'¿Puedo eliminar mi cuenta?','a'=>'Sí. Desde Ajustes > Privacidad puedes solicitar la eliminación y desindexación de tus alertas.'],
    ],
  ];
@endphp

<section class="bg-gray-50">
  <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
    @foreach ($faqs as $catId => $items)
      <div id="{{ $catId }}" class="scroll-mt-24">
        <h2 class="text-2xl md:text-3xl font-extrabold text-[#065F46]">
          @switch($catId)
            @case('publicar') Publicar alerta @break
            @case('pagos') Pagos y planes @break
            @case('mapa') Mapa y reportes @break
            @case('cuenta') Cuenta y soporte @break
          @endswitch
        </h2>

        <div class="mt-6 divide-y rounded-2xl border border-[#065F46]/15 bg-white">
          @foreach ($items as $i => $f)
            <details class="group p-5" data-faq>
              <summary class="cursor-pointer list-none flex items-center justify-between">
                <span class="font-semibold text-[#065F46]">{{ $f['q'] }}</span>
                <span class="text-xl text-gray-400 transition-transform group-open:rotate-45">+</span>
              </summary>
              <p class="mt-3 text-gray-700">{{ $f['a'] }}</p>
            </details>
          @endforeach
        </div>
      </div>

      @if (!$loop->last)
        <hr class="my-10 border-[#065F46]/10">
      @endif
    @endforeach
  </div>
</section>

{{-- =================== CTA FINAL =================== --}}
<section class="w-full bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46]">
  <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
    <div class="md:flex md:items-center md:justify-between gap-6">
      <h3 class="text-2xl md:text-3xl font-extrabold max-w-3xl">
        ¿No resolvimos tu duda?
      </h3>
      <a href="{{ route('map') }}"
         class="mt-6 md:mt-0 inline-flex items-center justify-center rounded-full px-8 py-4 font-semibold text-white
                bg-[#2563EB] shadow-lg hover:bg-[#1d4ed8] transition">
        Ver mapa de búsquedas
      </a>
    </div>
    <p class="mt-3 text-[#065F46]/80">También puedes escribir a soporte@petup.demo.</p>
  </div>
</section>

{{-- ===== TESTIMONIOS ===== --}}
<section class="bg-gray-50">
  <div class="max-w-7xl mx-auto px-6 py-16 md:py-20">
    <h3 class="text-3xl md:text-4xl font-extrabold text-center text-gray-900">No estás solo. Otras familias lo lograron.</h3>

    <div class="mt-10 grid md:grid-cols-3 gap-6">
      @php
        $cards = [
          ['img'=>'https://i.pravatar.cc/100?img=32','n'=>'Miriam Torres','c'=>'Encontró a su gata','t'=>'Excelente servicio, incluso en festivo. Mi gata volvió al día siguiente. Eternamente agradecida.','dark'=>false],
          ['img'=>'https://i.pravatar.cc/100?img=18','n'=>'Brenda Montenegro','c'=>'Encontró a su perro','t'=>'¡Todo fue rápido! La difusión ayudó muchísimo a encontrar a mi pequeño. Recomendado ❤️','dark'=>true],
          ['img'=>'https://i.pravatar.cc/100?img=11','n'=>'Marianela Miguens','c'=>'Encontró a su perro','t'=>'Estuvo perdido 4 días. Gracias a la publicación, lo hallamos a 12 km. ¡Felices!','dark'=>false],
        ];
      @endphp

      @foreach($cards as $i => $c)
        @php $isMiddle = $i === 1; @endphp

        <article @class([
            'rounded-3xl p-6 border shadow-sm transition',
            // Tarjeta de en medio: verde más oscuro
            'bg-[#064E3B] text-white border-[#064E3B]' => $isMiddle,
            // Resto con tu lógica original
            'bg-emerald-800 text-emerald-50' => $c['dark'] && ! $isMiddle,
            'bg-white' => ! $c['dark'],
        ])>
            <div class="flex items-center gap-3">
            <img src="{{ $c['img'] }}" class="w-10 h-10 rounded-full object-cover" alt="avatar">
            <div>
                <p class="font-semibold">{{ $c['n'] }}</p>
                <p class="{{ $isMiddle ? 'text-emerald-100' : ($c['dark'] ? 'text-emerald-200' : 'text-gray-500') }} text-sm">
                {{ $c['c'] }}
                </p>
            </div>
            </div>

            <p class="mt-4">{{ $c['t'] }}</p>

            <div class="mt-6 flex items-center justify-between">
            <div class="flex gap-1">
                @for($j=0; $j<5; $j++)
                <span class="w-4 h-4 inline-block text-yellow-400">★</span>
                @endfor
            </div>
            <span class="{{ $isMiddle ? 'text-emerald-100/60' : ($c['dark'] ? 'text-emerald-300/60' : 'text-gray-300') }} text-3xl">”</span>
            </div>
        </article>
        @endforeach

    </div>
  </div>
</section>

{{-- =================== Buscador (JS mínimo) =================== --}}
<script>
  (function () {
    const input = document.getElementById('faqSearch');
    if (!input) return;
    const items = Array.from(document.querySelectorAll('[data-faq]'));
    const empty = document.getElementById('noResults');

    input.addEventListener('input', () => {
      const q = input.value.trim().toLowerCase();
      let visible = 0;
      items.forEach(el => {
        const hit = el.textContent.toLowerCase().includes(q);
        el.classList.toggle('hidden', q && !hit);
        if (hit) visible++;
      });
      empty?.classList.toggle('hidden', !(q && visible === 0));
    });
  })();
</script>

{{-- (Opcional) Schema.org para SEO (seguro, sin Blade dentro del <script>) --}}
@php
  $schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'mainEntity' => collect($faqs)
      ->flatten(1) // une los grupos
      ->map(fn($f) => [
        '@type' => 'Question',
        'name'  => $f['q'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text'  => $f['a'],
        ],
      ])->values()->all(),
  ];
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
</script>

@endsection
