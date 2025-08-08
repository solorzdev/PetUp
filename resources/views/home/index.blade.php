<!-- resources/views/home/index.blade.php -->
@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] text-[#065F46] py-24 transition duration-500 ease-in-out">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="md:w-1/2 animate-fade-in-up">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                Perdida no significa imposible.
                <br>
                <span class="text-[#2563EB]">Volvamos a encontrarnos.</span>
            </h1>
            <p class="text-[#4B5563] text-lg md:text-xl mb-8">
                Lanza una alerta inteligente y conecta con vecinos, rescatistas y familias dispuestas a ayudar. Tu mascota está más cerca de lo que crees.
            </p>
            <form class="flex flex-col sm:flex-row items-center gap-4">
                <input type="text" placeholder="Nombre de tu mascota..." class="w-full sm:w-80 px-5 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2563EB]">
                <button type="submit" class="bg-[#2563EB] hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                    Buscar ahora
                </button>
            </form>
            <p class="mt-5 text-sm text-[#4B5563]">
                Respondemos al instante y activamos la red de búsqueda.
            </p>
            <p class="mt-2 text-[#2563EB] text-sm font-medium">
                ✓ Más de 8,900 reencuentros logrados en México 🇲🇽
            </p>
        </div>
        <div class="md:w-1/2 flex justify-center animate-fade-in">
            <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" alt="Ilustración mascota" class="w-80 h-auto drop-shadow-xl">
        </div>
    </div>
</section>

<section class="bg-[#F0F9FF] text-[#065F46] py-20">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
        <div class="md:w-1/2 animate-slide-in-left">
            <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee" class="rounded-xl shadow-lg w-full object-cover" alt="Mascota reunida">
        </div>
        <div class="md:w-1/2 md:pl-12 animate-slide-in-right">
            <h2 class="text-4xl font-bold mb-4">Tres pasos para un reencuentro rápido</h2>
            <p class="text-gray-700 mb-4">Creamos una alerta geolocalizada que se difunde en redes sociales y canales locales. Tu anuncio llega exactamente a las personas correctas.</p>
            <a href="#" class="inline-block bg-[#2563EB] hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">Ver planes de rescate</a>
            <div class="mt-6 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-3xl font-bold">82+</p>
                    <p class="text-sm text-gray-600">Búsquedas activas</p>
                </div>
                <div>
                    <p class="text-3xl font-bold">48+</p>
                    <p class="text-sm text-gray-600">Reencuentros hoy</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="max-w-6xl mx-auto px-4 text-center animate-fade-in">
        <h2 class="text-3xl font-bold mb-8">No estás solo. Estas familias lo consiguieron.</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-100 p-6 rounded-lg shadow hover:scale-105 transition-transform">
                <h3 class="font-bold text-[#065F46]">Javier Ortiz</h3>
                <p class="text-sm text-gray-500 mb-2">Aguascalientes</p>
                <p class="text-sm">“Mi gato se escondió por días. Gracias a esta plataforma, un vecino lo encontró en su patio.”</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow hover:scale-105 transition-transform">
                <h3 class="font-bold text-[#065F46]">David Romero</h3>
                <p class="text-sm text-gray-500 mb-2">Hermosillo</p>
                <p class="text-sm">“Encontramos a nuestro perrito al día siguiente. La rapidez del servicio fue impresionante.”</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow hover:scale-105 transition-transform">
                <h3 class="font-bold text-[#065F46]">Juan Carlos Pérez</h3>
                <p class="text-sm text-gray-500 mb-2">Guadalajara</p>
                <p class="text-sm">“Gracias a la difusión, apareció en 4 días. ¡Recomendado!”</p>
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
                <button @click="open = open === 1 ? null : 1" class="w-full text-left px-6 py-4 bg-[#D1FAE5] font-semibold text-lg text-gray-800 flex justify-between items-center">
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
                <button @click="open = open === 2 ? null : 2" class="w-full text-left px-6 py-4 bg-[#D1FAE5] font-semibold text-lg text-gray-800 flex justify-between items-center">
                    <span>2. Chimuelo y su gran amigo Hipo</span>
                    <span x-text="open === 2 ? '-' : '+'"></span>
                </button>
                <div x-show="open === 2" x-transition class="px-6 pb-6 pt-2 flex flex-col lg:flex-row items-center gap-6">
                    <img src="https://cdn.pixabay.com/photo/2016/02/19/11/53/dogs-1207816_640.jpg" alt="Hipo y Chimuelo" class="w-full lg:w-1/3 rounded-xl shadow-md object-cover">
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
                <button @click="open = open === 3 ? null : 3" class="w-full text-left px-6 py-4 bg-[#D1FAE5] font-semibold text-lg text-gray-800 flex justify-between items-center">
                    <span>3. Sam, el viajero inesperado</span>
                    <span x-text="open === 3 ? '-' : '+'"></span>
                </button>
                <div x-show="open === 3" x-transition class="px-6 pb-6 pt-2 flex flex-col lg:flex-row items-center gap-6">
                    <img src="https://cdn.pixabay.com/photo/2015/03/26/10/01/husky-690545_640.jpg" alt="Sam" class="w-full lg:w-1/3 rounded-xl shadow-md object-cover">
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

<section class="bg-[#E0F7FA] py-20 text-center animate-fade-in">
    <h2 class="text-2xl md:text-4xl font-bold mb-4">Únete a nuestra red de búsqueda y reencuentros</h2>
    <p class="text-[#4B5563] mb-6">Explora casos en tiempo real y sé parte de una comunidad que ayuda.</p>
    <a href="#" class="inline-block bg-[#2563EB] text-white font-semibold px-6 py-3 rounded-md shadow-md hover:scale-105 transition">Explorar mapa</a>
</section>
@endsection
