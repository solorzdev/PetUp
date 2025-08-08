<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETUP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav x-data="{ open: false }" class="sticky top-0 z-50 bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] shadow-md backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <span class="text-2xl">🐶</span>
                <h1 class="text-xl md:text-2xl font-extrabold text-[#065F46]">PetUp</h1>
            </div>

            <!-- Menú en escritorio -->
            <ul class="hidden md:flex space-x-8 text-[#065F46] font-medium text-base">
                <li><a href="#" class="hover:text-[#2563EB] transition">Inicio</a></li>
                <li><a href="#" class="hover:text-[#2563EB] transition">Quiénes somos</a></li>
                <li><a href="#" class="hover:text-[#2563EB] transition">Preguntas frecuentes</a></li>
                <li><a href="#" class="hover:text-[#2563EB] transition">Mapa de búsquedas</a></li>
                <li><a href="#" class="hover:text-[#2563EB] transition">Familias reunidas</a></li>
                <li><a href="#" class="hover:text-[#2563EB] transition">Precios</a></li>
            </ul>

            <!-- Botón hamburguesa -->
            <button @click="open = true" class="md:hidden text-[#065F46] text-3xl focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                </svg>
            </button>
        </div>

        <!-- Drawer lateral móvil -->
        <div
            class="fixed inset-0 z-50 flex md:hidden"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            style="display: none;"
        >
            <!-- Overlay oscuro -->
            <div class="fixed inset-0 bg-black bg-opacity-30" @click="open = false"></div>

            <!-- Panel lateral -->
            <div class="relative bg-white w-72 max-w-full h-full shadow-xl z-50 flex flex-col p-6 space-y-4">
                <!-- Botón cerrar -->
                <button @click="open = false" class="absolute top-4 right-4 text-[#065F46] text-2xl">
                    ✕
                </button>

                <!-- Navegación -->
                <nav class="mt-12 space-y-4 text-[#065F46] text-base font-medium">
                    <a href="#" class="block border-b border-gray-200 pb-2 hover:text-[#2563EB]">Inicio</a>
                    <a href="#" class="block border-b border-gray-200 pb-2 hover:text-[#2563EB]">Quiénes somos</a>
                    <a href="#" class="block border-b border-gray-200 pb-2 hover:text-[#2563EB]">Preguntas frecuentes</a>
                    <a href="#" class="block border-b border-gray-200 pb-2 hover:text-[#2563EB]">Mapa de búsquedas</a>
                    <a href="#" class="block border-b border-gray-200 pb-2 hover:text-[#2563EB]">Familias reunidas</a>
                    <a href="#" class="block border-b border-gray-200 pb-2 hover:text-[#2563EB]">Precios</a>
                    <a href="#" class="block mt-4 text-center border border-[#065F46] rounded-full px-6 py-2 text-sm hover:bg-[#065F46] hover:text-white transition">
                        VER PLANES DE RESCATE →
                    </a>
                </nav>
            </div>
        </div>
    </nav>


    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] py-10 text-center text-[#065F46]">
        <div class="max-w-4xl mx-auto px-4">
            <p class="text-lg font-semibold mb-2">PetUp - Conectando corazones, rescatando vidas</p>
            <div class="flex justify-center gap-6 text-sm mb-4">
                <a href="#" class="hover:text-[#2563EB] transition">Términos</a>
                <a href="#" class="hover:text-[#2563EB] transition">Privacidad</a>
                <a href="#" class="hover:text-[#2563EB] transition">Contacto</a>
            </div>
            <p class="text-xs text-gray-600">© {{ date('Y') }} PetUp. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
