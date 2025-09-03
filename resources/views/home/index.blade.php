<!-- resources/views/home/index.blade.php -->
@extends('layouts.app')

@section('content')
<section class="bg-[#32BAEA] text-white py-24">
  <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-10">
    <div class="md:w-1/2">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
        Perdida no significa imposible.
        <br>
        <span class="text-[#5642BB]">Volvamos a encontrarnos.</span>
      </h1>
      <p class="text-white/90 text-lg md:text-xl mb-8">
        Lanza una alerta inteligente y conecta con vecinos, rescatistas y familias dispuestas a ayudar.
      </p>
      <form class="flex flex-col sm:flex-row items-center gap-4">
        <input type="text" placeholder="Nombre de tu mascota..."
               class="w-full sm:w-80 px-5 py-3 rounded-lg border border-white/40 bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-[#5642BB]">
        <button type="submit"
                class="bg-[#5642BB] hover:bg-[#382C77] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
          Buscar ahora
        </button>
      </form>
      <p class="mt-5 text-sm text-white/80">
        Respondemos al instante y activamos la red de búsqueda.
      </p>
      <p class="mt-2 text-[#5642BB] text-sm font-medium">
        ✓ Más de 8,900 reencuentros logrados en México 🇲🇽
      </p>
    </div>
    <div class="md:w-1/2 flex justify-center">
      <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png"
           alt="Ilustración mascota" class="w-80 h-auto drop-shadow-xl">
    </div>
  </div>
</section>


<section class="bg-white text-gray-800 py-20">
  <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
    <div class="md:w-1/2">
      <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee"
           class="rounded-xl shadow-lg w-full object-cover" alt="Mascota reunida">
    </div>
    <div class="md:w-1/2 md:pl-12">
      <h2 class="text-4xl font-bold mb-4 text-[#5642BB]">Tres pasos para un reencuentro rápido</h2>
      <p class="text-gray-600 mb-4">
        Creamos una alerta geolocalizada que se difunde en redes sociales y canales locales.
      </p>
      <a href="{{ route('pricing') }}"
         class="inline-block bg-[#E53C49] hover:bg-red-700 text-white px-6 py-3 rounded-md font-medium shadow">
         Ver planes de rescate
      </a>
      <div class="mt-6 grid grid-cols-2 gap-6">
        <div>
          <p class="text-3xl font-bold text-[#5642BB]">82+</p>
          <p class="text-sm text-gray-600">Búsquedas activas</p>
        </div>
        <div>
          <p class="text-3xl font-bold text-[#FBB03B]">48+</p>
          <p class="text-sm text-gray-600">Reencuentros hoy</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="bg-[#FBB03B]/10 py-20">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-8 text-[#5642BB]">
      No estás solo. Estas familias lo consiguieron.
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow hover:scale-105 transition-transform">
        <h3 class="font-bold text-[#5642BB]">Javier Ortiz</h3>
        <p class="text-sm text-gray-500 mb-2">Aguascalientes</p>
        <p class="text-sm text-gray-700">“Mi gato se escondió por días...”</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow hover:scale-105 transition-transform">
        <h3 class="font-bold text-[#5642BB]">David Romero</h3>
        <p class="text-sm text-gray-500 mb-2">Hermosillo</p>
        <p class="text-sm text-gray-700">“Encontramos a nuestro perrito...”</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow hover:scale-105 transition-transform">
        <h3 class="font-bold text-[#5642BB]">Juan Carlos Pérez</h3>
        <p class="text-sm text-gray-500 mb-2">Guadalajara</p>
        <p class="text-sm text-gray-700">“Gracias a la difusión...”</p>
      </div>
    </div>
  </div>
</section>

<!-- Sección de historias con animación tipo acordeón -->
<section class="bg-[#E0F7FA] py-20">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Historias que inspiran</h2>

        <div x-data="{ open: 1 }" class="space-y-6">
            <!-- Historia 1 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all">
                <button @click="open = open === 1 ? null : 1" class="w-full text-left px-6 py-4 bg-[#32BAEA] font-semibold text-lg text-gray-800 flex justify-between items-center">
                    <span>1. El regreso de Linda con Luciana</span>
                    <span x-text="open === 1 ? '-' : '+'"></span>
                </button>
                <div x-show="open === 1" x-transition class="px-6 pb-6 pt-2 flex flex-col lg:flex-row items-center gap-6">
                    <img src="https://images.unsplash.com/photo-1558788353-f76d92427f16" alt="Linda" class="w-full lg:w-1/3 rounded-xl shadow-md object-cover">
                    <div class="lg:w-2/3">
                        <h3 class="text-[#064E3B] font-semibold text-md mb-2">Su historia</h3>
                        <p class="mb-4 text-gray-700">Luciana contrató el servicio 36 días después de perder a Linda. Gracias a una alerta geolocalizada, la encontraron en solo 4 días.</p>
                        <h4 class="text-[#064E3B] font-semibold text-md mb-1">Resultados</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Un trabajador rural vio el anuncio de Linda.</li>
                            <li>La alerta alcanzó a 98,000 personas.</li>
                            <li>Linda volvió sana y salva con su familia.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Historia 2 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all">
                <button @click="open = open === 2 ? null : 2" class="w-full text-left px-6 py-4 bg-[#32BAEA] font-semibold text-lg text-gray-800 flex justify-between items-center">
                    <span>2. Chimuelo y su gran amigo Hipo</span>
                    <span x-text="open === 2 ? '-' : '+'"></span>
                </button>
                <div x-show="open === 2" x-transition class="px-6 pb-6 pt-2 flex flex-col lg:flex-row items-center gap-6">
                    <img src="https://images.pexels.com/photos/1108099/pexels-photo-1108099.jpeg" alt="Hipo y Chimuelo" class="w-full lg:w-1/3 rounded-xl shadow-md object-cover">
                    <div class="lg:w-2/3">
                        <h3 class="text-[#064E3B] font-semibold text-md mb-2">Su historia</h3>
                        <p class="mb-4 text-gray-700">Después de semanas de angustia, Sebastián lanzó una alerta para encontrar a sus perros. Los vecinos ayudaron rápidamente.</p>
                        <h4 class="text-[#064E3B] font-semibold text-md mb-1">Resultados</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Los vecinos reconocieron a los perros por la foto.</li>
                            <li>Hipo y Chimuelo fueron encontrados jugando juntos.</li>
                            <li>Reencuentro con muchas lágrimas y felicidad.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Historia 3 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all">
                <button @click="open = open === 3 ? null : 3" class="w-full text-left px-6 py-4 bg-[#32BAEA] font-semibold text-lg text-gray-800 flex justify-between items-center">
                    <span>3. Sam, el viajero inesperado</span>
                    <span x-text="open === 3 ? '-' : '+'"></span>
                </button>
                <div x-show="open === 3" x-transition class="px-6 pb-6 pt-2 flex flex-col lg:flex-row items-center gap-6">
                    <img src="https://images.pexels.com/photos/333083/pexels-photo-333083.jpeg" alt="Sam" class="w-full lg:w-1/3 rounded-xl shadow-md object-cover">
                    <div class="lg:w-2/3">
                        <h3 class="text-[#064E3B] font-semibold text-md mb-2">Su historia</h3>
                        <p class="mb-4 text-gray-700">Sam fue adoptado temporalmente por otra familia que lo cuidó. Al recibir la alerta, coordinaron su regreso sin problema.</p>
                        <h4 class="text-[#064E3B] font-semibold text-md mb-1">Resultados</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Sam llegó limpio y con collar nuevo.</li>
                            <li>Ambas familias mantuvieron contacto.</li>
                            <li>Hoy Sam es doblemente querido.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#5642BB] py-20 text-center text-white">
  <h2 class="text-2xl md:text-4xl font-bold mb-4">
    Únete a nuestra red de búsqueda y reencuentros
  </h2>
  <p class="mb-6 text-white/90">
    Explora casos en tiempo real y sé parte de una comunidad que ayuda.
  </p>
  <a href="{{ route('map') }}"
     class="inline-block bg-[#FBB03B] text-[#0B1220] font-semibold px-6 py-3 rounded-md shadow-md hover:scale-105 transition">
    Explorar mapa
  </a>
</section>

@endsection
