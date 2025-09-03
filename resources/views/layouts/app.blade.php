<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BuscaDog</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
        <style>[x-cloak]{display:none!important}</style>

    </head>
    <body class="bg-gray-100 text-gray-800">
        <!-- Navbar -->
        <nav x-data="{ open:false }" x-trap.noscroll="open"
            class="sticky top-0 z-50 bg-[#32BAEA] text-white shadow-md">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="BuscaDog Logo" class="h-8 md:h-10 w-auto">
                    </a>
                </div>

                <!-- Desktop -->
                <ul class="hidden md:flex gap-8 font-medium">
                    <li>
                        <a href="{{ route('home') }}"
                        @class(['hover:text-[#5642BB]','text-[#5642BB] font-semibold'=> request()->routeIs('home')])>
                        Inicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                        @class(['hover:text-[#5642BB]','text-[#5642BB] font-semibold'=> request()->routeIs('about')])>
                        Quiénes somos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}"
                        @class(['hover:text-[#5642BB]','text-[#5642BB] font-semibold'=> request()->routeIs('faq')])>
                        Preguntas frecuentes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('map') }}"
                        @class(['hover:text-[#5642BB]','text-[#5642BB] font-semibold'=> request()->routeIs('map')])>
                        Mapa de búsquedas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reunions') }}"
                        @class(['hover:text-[#5642BB]','text-[#5642BB] font-semibold'=> request()->routeIs('reunions')])>
                        Familias reunidas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pricing') }}"
                        @class(['hover:text-[#5642BB]','text-[#5642BB] font-semibold'=> request()->routeIs('pricing')])>
                        Precios
                        </a>
                    </li>
                    </ul>

                <!-- Burger -->
                <button @click="open=true" class="md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                </svg>
                </button>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-10 text-center bg-[#32BAEA] text-white">
            <div class="max-w-4xl mx-auto px-4">
                <p class="text-lg font-semibold mb-2">BuscaDog - Conectando corazones, rescatando vidas</p>
                <div class="flex justify-center gap-6 text-sm mb-4">
                <a href="#" class="hover:text-[#FBB03B] transition">Términos</a>
                <a href="#" class="hover:text-[#FBB03B] transition">Privacidad</a>
                <a href="#" class="hover:text-[#FBB03B] transition">Contacto</a>
                </div>
                <p class="text-xs text-white/80">© {{ date('Y') }} BuscaDog. Todos los derechos reservados.</p>
            </div>
        </footer>

    </body>
</html>
