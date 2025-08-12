<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETUP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>

</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav x-data="{ open:false }" x-trap.noscroll="open"
     class="sticky top-0 z-50 bg-gradient-to-br from-[#DCFCE7] to-[#C7F7DE] shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
            <span class="text-2xl">🐶</span>
            <h1 class="text-xl md:text-2xl font-extrabold text-[#065F46]">PetUp</h1>
            </div>

            <!-- Desktop -->
            <ul class="hidden md:flex gap-8 text-[#065F46] font-medium">
                <li><a href="{{ route('home') }}"     @class(['hover:text-[#2563EB]','text-[#2563EB] font-semibold'=> request()->routeIs('home')])>Inicio</a></li>
                <li><a href="{{ route('about') }}"    @class(['hover:text-[#2563EB]','text-[#2563EB] font-semibold'=> request()->routeIs('about')])>Quiénes somos</a></li>
                <li><a href="{{ route('faq') }}"      @class(['hover:text-[#2563EB]','text-[#2563EB] font-semibold'=> request()->routeIs('faq')])>Preguntas frecuentes</a></li>
                <li><a href="{{ route('map') }}"      @class(['hover:text-[#2563EB]','text-[#2563EB] font-semibold'=> request()->routeIs('map')])>Mapa de búsquedas</a></li>
                <li><a href="{{ route('reunions') }}" @class(['hover:text-[#2563EB]','text-[#2563EB] font-semibold'=> request()->routeIs('reunions')])>Familias reunidas</a></li>
                <li><a href="{{ route('pricing') }}"  @class(['hover:text-[#2563EB]','text-[#2563EB] font-semibold'=> request()->routeIs('pricing')])>Precios</a></li>
            </ul>

            <!-- Burger -->
            <button @click="open=true" class="md:hidden text-[#065F46]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
            </button>
        </div>

        <!-- ===================== Mobile Drawer ===================== -->
        <!-- wrapper (no layout shift, sits above page) -->
        <div x-show="open" x-cloak style="display:none" class="fixed inset-0 z-[60] md:hidden">
        <!-- overlay blanco -->
        <div class="absolute inset-0 bg-white/90" @click="open=false" x-transition.opacity></div>

        <!-- sliding panel -->
        <div
            class="absolute left-0 top-0 h-full w-10/12 max-w-sm bg-white shadow-2xl
                will-change-transform transition-transform duration-300 ease-out"
            :class="open ? 'translate-x-0' : '-translate-x-full'"
            x-transition:enter
            x-transition:leave
        >
            <!-- header -->
            <div class="flex items-center justify-between px-6 py-4 border-b">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🐶</span>
                <span class="font-extrabold text-lg text-[#065F46]">PetUp</span>
            </div>
            <button @click="open=false" class="text-[#065F46]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            </div>

            <!-- links -->
            <nav class="px-6 py-4 text-[#065F46] font-medium space-y-4">
                <a @click="open=false" class="block border-b pb-3 hover:text-[#2563EB] {{ request()->routeIs('home') ? 'text-[#2563EB] font-semibold' : '' }}" href="{{ route('home') }}">Inicio</a>
                <a @click="open=false" class="block border-b pb-3 hover:text-[#2563EB] {{ request()->routeIs('about') ? 'text-[#2563EB] font-semibold' : '' }}" href="{{ route('about') }}">Quiénes somos</a>
                <a @click="open=false" class="block border-b pb-3 hover:text-[#2563EB] {{ request()->routeIs('faq') ? 'text-[#2563EB] font-semibold' : '' }}" href="{{ route('faq') }}">Preguntas frecuentes</a>
                <a @click="open=false" class="block border-b pb-3 hover:text-[#2563EB] {{ request()->routeIs('map') ? 'text-[#2563EB] font-semibold' : '' }}" href="{{ route('map') }}">Mapa de búsquedas</a>
                <a @click="open=false" class="block border-b pb-3 hover:text-[#2563EB] {{ request()->routeIs('reunions') ? 'text-[#2563EB] font-semibold' : '' }}" href="{{ route('reunions') }}">Familias reunidas</a>
                <a @click="open=false" class="block border-b pb-3 hover:text-[#2563EB] {{ request()->routeIs('pricing') ? 'text-[#2563EB] font-semibold' : '' }}" href="{{ route('pricing') }}">Precios</a>

                <a href="{{ route('pricing') }}"
                    @click="open=false"
                    class="mt-6 block text-center border border-[#065F46] rounded-full px-6 py-2 text-sm
                            hover:bg-[#065F46] hover:text-white transition">
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
