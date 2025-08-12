@extends('layouts.app')

@section('content')

{{-- HERO--}}
<section class="bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-black">
  <div class="max-w-7xl mx-auto px-6 py-16 md:py-24">

    <div class="grid md:grid-cols-12 items-center gap-8">
      {{-- Texto --}}
      <div class="md:col-span-7">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight">Nuestra razón de ser</h1>
        <p class="mt-4 text-black/80 text-lg">
          Transformamos la angustia en esperanza. Reunimos familias con sus mascotas mediante alertas geolocalizadas y una red que sí responde.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4">
          <a href="{{ route('map') }}"
             class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white shadow hover:bg-blue-700 transition">
            Ver mapa de búsquedas
          </a>
          <a href="{{ route('pricing') }}"
             class="inline-flex items-center justify-center rounded-xl border border-black/30 px-6 py-3 font-semibold text-black hover:bg-black hover:text-white transition">
            Planes de rescate
          </a>
        </div>
      </div>

      {{-- Imagen + badge --}}
      <div class="md:col-span-5 relative">
        <div class="rounded-3xl overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,.12)] bg-white/40 backdrop-blur
                    w-full md:w-11/12 aspect-[4/3] max-h-[460px]">
          <img
            src="https://placedog.net/900/640?random"
            alt="Familia reunida con su perro"
            class="w-full h-full object-cover">
        </div>

        <div class="absolute -bottom-6 left-6 bg-white text-gray-800 rounded-2xl shadow-lg px-4 py-3 flex items-center gap-3">
          <span class="grid place-items-center w-7 h-7 rounded-full bg-yellow-400 text-gray-900 font-bold">✓</span>
          <div class="text-sm leading-tight">
            <p class="font-semibold">Familia <span class="text-black">¡Reunida!</span></p>
            <p class="text-gray-500">en 72 horas</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== HISTORIA DESTACADA ===== --}}
<section class="bg-gray-50">
  <div class="max-w-7xl mx-auto px-6 py-16 md:py-20 grid md:grid-cols-12 gap-10 items-center">
    <div class="md:col-span-6 relative">
      <img src="https://images.unsplash.com/photo-1568572933382-74d440642117?q=80&w=1200&auto=format&fit=crop"
           alt="Pepper descansando en casa"
           class="rounded-3xl w-full object-cover shadow-lg">
      <div class="absolute -left-6 -bottom-6 hidden md:block">
        <div class="rounded-3xl bg-white shadow-xl px-4 py-2 text-sm text-gray-600">
          🐾 Historias reales cada semana
        </div>
      </div>
    </div>

    <div class="md:col-span-6">
      <h2 class="text-4xl font-extrabold text-gray-900">Pepper, nuestra inspiración</h2>
      <p class="mt-4 text-gray-700">
        En 2021, durante una mudanza, <span class="font-semibold">Ana</span> perdió a <span class="font-semibold">Pepper</span>.
        Sin resultados por días, activó una alerta geolocalizada. Ese mismo día, un vecino vio el aviso y llamó.
        El reencuentro nos marcó: de ahí nace <span class="font-semibold text-emerald-700">PetUp</span>.
      </p>

      <p class="mt-6 italic text-gray-600">Escucha la historia completa:</p>
      <div class="mt-2 flex items-center gap-3">
        <button class="w-10 h-10 rounded-full bg-emerald-600 text-white grid place-items-center shadow hover:bg-emerald-700">►</button>
        <div class="flex gap-1 h-8 items-end">
          <span class="w-1.5 bg-gray-300 animate-wave" style="animation-delay:.0s"></span>
          <span class="w-1.5 bg-gray-300 animate-wave" style="animation-delay:.1s"></span>
          <span class="w-1.5 bg-gray-300 animate-wave" style="animation-delay:.2s"></span>
          <span class="w-1.5 bg-gray-300 animate-wave" style="animation-delay:.3s"></span>
          <span class="w-1.5 bg-gray-300 animate-wave" style="animation-delay:.4s"></span>
          <span class="w-1.5 bg-gray-300 animate-wave" style="animation-delay:.5s"></span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== NUESTRO EQUIPO / FUNDADOR ===== --}}
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-6 py-16 md:py-20">
    <div class="grid md:grid-cols-12 gap-10 items-center">
      <div class="md:col-span-5">
        <h3 class="text-3xl md:text-4xl font-extrabold text-gray-900">Nuestro fundador</h3>
        <div class="mt-6 flex items-center gap-4">
          <img src="https://i.pravatar.cc/120?img=15" class="w-14 h-14 rounded-full object-cover" alt="Fundador">
          <div>
            <p class="font-semibold text-gray-900">Santiago Elizalde</p>
            <p class="text-gray-500 text-sm">CEO y creador de PetUp</p>
          </div>
        </div>
      </div>

      <blockquote class="md:col-span-7 rounded-3xl bg-gray-50 p-8 md:p-10 shadow-sm border">
        <p class="text-2xl md:text-3xl font-semibold text-gray-800 leading-snug">
          “Sé lo que se siente perder a un integrante de la familia. No vamos a detenernos hasta reunir cada historia.”
        </p>
      </blockquote>
    </div>
  </div>
</section>

{{-- ===== CTA MAPA ===== --}}
<section class="w-full bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46]">
  <div class="max-w-7xl mx-auto px-6 py-16 md:py-24">
    <!-- fila: título + botón -->
    <div class="md:flex md:items-center md:justify-between gap-6">
      <h3 class="text-3xl md:text-5xl font-extrabold leading-tight max-w-3xl">
        Únete al mapa de búsquedas y reencuentros
      </h3>

      <a href="{{ route('map') }}"
         class="mt-6 md:mt-0 inline-flex items-center justify-center shrink-0
                rounded-full px-8 py-4 font-semibold text-white
                bg-[#2563EB] shadow-lg hover:bg-[#1d4ed8] focus:outline-none
                focus:ring-4 focus:ring-blue-300 transition">
        Explorar mapa
      </a>
    </div>

    <p class="mt-6 text-[#065F46]/80 md:text-lg">
      Explora búsquedas en tiempo real y celebra cada final feliz.
    </p>
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

{{-- ===== estilos locales mínimos ===== --}}
<style>
  .animate-wave{animation:wave 1.1s ease-in-out infinite; height:18px; border-radius:.25rem}
  @keyframes wave{
    0%,100%{height:6px;opacity:.6}
    50%{height:18px;opacity:1}
  }
</style>
@endsection
