@extends('layouts.app')

@section('title', 'Precios')

@section('content')
<div class="w-full">

    {{-- 1) HERO sólido + collage lateral (espaciado reducido) --}}
    <section class="relative flex items-center overflow-hidden py-12 md:py-16">
        <div class="absolute inset-0 -z-10 bg-[#32BAEA]"></div>

        {{-- patrón sutil de huellas (en blanco translúcido) --}}
        <div class="absolute inset-0 -z-10 opacity-25 [mask-image:linear-gradient(to_bottom,black,transparent)]">
            <svg class="w-[140%] h-full -translate-x-1/6" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <defs>
                    <pattern id="paws" width="120" height="120" patternUnits="userSpaceOnUse">
                        <g fill="#FFFFFF" fill-opacity=".18">
                            <circle cx="20" cy="20" r="6" />
                            <circle cx="36" cy="16" r="4" />
                            <circle cx="36" cy="28" r="4" />
                            <circle cx="28" cy="34" r="4" />
                        </g>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#paws)"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 w-full">
            <div class="flex items-center">
                <div class="text-center md:text-left">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-white/80 text-[#0B1220] shadow border border-white/60">
                        🐾 Demo • Precios simulados
                    </span>
                    <h1 class="mt-4 text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                        Planes que crecen con tu misión
                    </h1>
                    <p class="mt-4 text-white/90 max-w-xl mx-auto md:mx-0">
                        Publica alertas, llega más lejos y ayuda a reunir mascotas con sus familias.
                    </p>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                        <a href="#planes" class="px-6 py-3 bg-[#5642BB] hover:bg-[#382C77] text-white rounded-xl font-semibold shadow transition">
                            Ver planes
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-white/90 hover:bg-white text-[#0B1220] rounded-xl font-semibold border shadow transition">
                                Crear cuenta
                            </a>
                        @else
                            <a href="{{ url('/contacto') }}" class="px-6 py-3 bg-white/90 hover:bg-white text-[#0B1220] rounded-xl font-semibold border shadow transition">
                                Contacto
                            </a>
                        @endif
                    </div>

                    {{-- mini-métricas --}}
                    <dl class="mt-6 grid grid-cols-3 gap-3 text-sm">
                        <div class="bg-white/90 backdrop-blur border rounded-xl p-3 text-center">
                            <dt class="text-gray-600">Alertas</dt>
                            <dd class="text-lg font-bold text-[#5642BB]">1,200+</dd>
                        </div>
                        <div class="bg-white/90 backdrop-blur border rounded-xl p-3 text-center">
                            <dt class="text-gray-600">Reunificaciones</dt>
                            <dd class="text-lg font-bold text-[#5642BB]">72%</dd>
                        </div>
                        <div class="bg-white/90 backdrop-blur border rounded-xl p-3 text-center">
                            <dt class="text-gray-600">Soporte</dt>
                            <dd class="text-lg font-bold text-[#5642BB]">24/7</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- collage de imágenes --}}
            <div class="hidden md:grid grid-cols-3 gap-4 content-center">
                <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=800&auto=format&fit=crop" alt="Perro feliz"
                     class="rounded-2xl shadow-lg aspect-[3/4] object-cover">
                <img src="https://images.unsplash.com/photo-1507146426996-ef05306b995a?q=80&w=600&auto=format&fit=crop" alt="Gato curioso"
                     class="rounded-2xl shadow-lg aspect-square object-cover self-end">
                <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=600&auto=format&fit=crop" alt="Huella"
                     class="rounded-2xl shadow-lg aspect-[3/4] object-cover">
                <img src="https://images.unsplash.com/photo-1534361960057-19889db9621e?q=80&w=800&auto=format&fit=crop" alt="Rescate"
                     class="rounded-2xl shadow-lg aspect-[4/3] object-cover col-span-2">
                <img src="https://images.pexels.com/photos/6234980/pexels-photo-6234980.jpeg" alt="Consulta veterinaria"
                     class="rounded-2xl shadow-lg aspect-square object-cover">
            </div>
        </div>
    </section>

    {{-- 2) PLANES --}}
    <section id="planes" class="py-12">
        <div class="max-w-7xl mx-auto px-4 w-full">
            <h2 class="text-3xl font-extrabold text-[#5642BB] text-center">Planes y Precios</h2>
            <p class="text-gray-600 text-center mt-2">Elige el plan que mejor se adapte a tus objetivos.</p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                {{-- Básico --}}
                <article class="group relative rounded-2xl border border-[#32BAEA]/30 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="absolute -inset-px rounded-2xl bg-[#32BAEA]/10 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <h3 class="text-xl font-semibold text-gray-900">Básico</h3>
                        <p class="text-gray-500 mt-1">Ideal para publicaciones ocasionales.</p>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-[#5642BB]">$0</span>
                            <span class="text-gray-500">/gratis</span>
                        </div>
                        <ul class="mt-5 space-y-2 text-sm text-gray-700">
                            <li class="flex gap-2">✅ 1 publicación por mes</li>
                            <li class="flex gap-2">✅ Soporte por email</li>
                            <li class="flex gap-2">🚫 Sin imágenes adicionales</li>
                        </ul>
                        <button class="mt-6 w-full bg-[#5642BB] hover:bg-[#382C77] text-white py-2 rounded-lg font-medium transition">
                            Elegir
                        </button>
                        <p class="text-xs text-gray-400 mt-3">Para comenzar sin fricción.</p>
                    </div>
                </article>

                {{-- Premium (destacado) --}}
                <article class="group relative rounded-2xl border-2 border-[#5642BB] bg-white p-6 shadow-md transition hover:shadow-xl">
                    <span class="absolute -top-3 right-4 inline-block text-xs font-semibold bg-[#5642BB] text-white px-3 py-1 rounded-full shadow">
                        Más popular
                    </span>
                    <div class="relative">
                        <h3 class="text-xl font-semibold text-gray-900">Premium</h3>
                        <p class="text-gray-500 mt-1">Mayor visibilidad y publicaciones ilimitadas.</p>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-[#5642BB]">$99</span>
                            <span class="text-gray-500">/mes</span>
                        </div>
                        <ul class="mt-5 space-y-2 text-sm text-gray-700">
                            <li class="flex gap-2">✅ Publicaciones ilimitadas</li>
                            <li class="flex gap-2">✅ Soporte prioritario</li>
                            <li class="flex gap-2">✅ Imágenes y videos</li>
                        </ul>
                        <button class="mt-6 w-full bg-[#FBB03B] hover:bg-[#e89a17] text-[#0B1220] py-2 rounded-lg font-semibold transition">
                            Elegir Premium
                        </button>
                        <p class="text-xs text-gray-400 mt-3">La mejor opción para uso frecuente.</p>
                    </div>
                </article>

                {{-- Empresarial --}}
                <article class="group relative rounded-2xl border border-[#32BAEA]/30 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="absolute -inset-px rounded-2xl bg-[#32BAEA]/10 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <h3 class="text-xl font-semibold text-gray-900">Empresarial</h3>
                        <p class="text-gray-500 mt-1">Para refugios y veterinarias.</p>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-[#5642BB]">$199</span>
                            <span class="text-gray-500">/mes</span>
                        </div>
                        <ul class="mt-5 space-y-2 text-sm text-gray-700">
                            <li class="flex gap-2">✅ Publicaciones ilimitadas</li>
                            <li class="flex gap-2">✅ Anuncios destacados</li>
                            <li class="flex gap-2">✅ Reportes de interacción</li>
                        </ul>
                        <button class="mt-6 w-full bg-[#5642BB] hover:bg-[#382C77] text-white py-2 rounded-lg font-medium transition">
                            Contactar Ventas
                        </button>
                        <p class="text-xs text-gray-400 mt-3">Soporte dedicado y asesoría.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- 3) ¿Cómo funciona? --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 w-full">
            <div class="order-2 md:order-1 self-center">
                <h3 class="text-3xl font-extrabold text-[#5642BB]">¿Cómo funciona?</h3>
                <p class="text-gray-600 mt-2">Un flujo simple para que tu alerta tenga impacto.</p>
                <ol class="mt-6 space-y-4">
                    <li class="flex gap-4">
                        <div class="h-9 w-9 rounded-full bg-[#32BAEA] flex items-center justify-center font-bold text-[#0B1220]">1</div>
                        <div>
                            <div class="font-semibold text-gray-900">Crea la alerta</div>
                            <p class="text-gray-600 text-sm">Sube fotos, describe la mascota y señala el punto en el mapa.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <div class="h-9 w-9 rounded-full bg-[#32BAEA] flex items-center justify-center font-bold text-[#0B1220]">2</div>
                        <div>
                            <div class="font-semibold text-gray-900">Gana visibilidad</div>
                            <p class="text-gray-600 text-sm">Comparte con la comunidad y recibe reportes en tiempo real.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <div class="h-9 w-9 rounded-full bg-[#32BAEA] flex items-center justify-center font-bold text-[#0B1220]">3</div>
                        <div>
                            <div class="font-semibold text-gray-900">Reúnete</div>
                            <p class="text-gray-600 text-sm">Coordina el encuentro seguro con apoyo del equipo.</p>
                        </div>
                    </li>
                </ol>
                <div class="mt-6">
                    <a href="#planes" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-[#5642BB] hover:bg-[#382C77] text-white font-semibold transition">
                        Empezar ahora
                    </a>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <img src="https://images.pexels.com/photos/7362886/pexels-photo-7362886.jpeg" alt="Persona usando mapa para buscar mascota"
                    class="rounded-3xl shadow-2xl aspect-video object-cover">
            </div>
        </div>
    </section>

    {{-- 4) Testimonios + imágenes --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 w-full">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-3xl font-extrabold text-[#5642BB]">La comunidad opina</h3>
                    <p class="text-gray-600 mt-2">Confianza que se construye con resultados.</p>

                    <div class="mt-6 space-y-4">
                        <blockquote class="bg-white border border-[#32BAEA]/40 rounded-2xl p-5 shadow-sm">
                            <p class="text-gray-700">“En 48 horas recibimos el reporte correcto. Recuperamos a Milo.”</p>
                            <footer class="mt-2 text-sm text-gray-500">— Sofía & “Milo”</footer>
                        </blockquote>
                        <blockquote class="bg-white border border-[#32BAEA]/40 rounded-2xl p-5 shadow-sm">
                            <p class="text-gray-700">“Como refugio, el plan Empresarial nos dio visibilidad real.”</p>
                            <footer class="mt-2 text-sm text-gray-500">— Refugio Paws MX</footer>
                        </blockquote>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=800&auto=format&fit=crop" class="rounded-2xl shadow-lg aspect-video object-cover" alt="Apoyo comunitario 1">
                    <img src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=800&auto=format&fit=crop" class="rounded-2xl shadow-lg aspect-video object-cover" alt="Apoyo comunitario 2">
                    <img src="https://images.unsplash.com/photo-1508672019048-805c876b67e2?q=80&w=800&auto=format&fit=crop" class="rounded-2xl shadow-lg aspect-video object-cover col-span-2" alt="Apoyo comunitario 3">
                </div>
            </div>
        </div>

        {{-- CTA inferior --}}
        <section class="py-4">
            <div class="max-w-full mx-auto px-4 w-full text-center bg-[#5642BB] border border-[#5642BB] rounded-3xl p-8 md:p-10 shadow">
                <h3 class="text-3xl font-extrabold text-white">¿Listo para empezar?</h3>
                <p class="text-white/90 mt-2">Crea tu cuenta y publica tu primera alerta en minutos.</p>
                <div class="mt-5 flex flex-col sm:flex-row gap-3 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-[#FBB03B] hover:bg-[#e89a17] text-[#0B1220] rounded-xl font-semibold shadow transition">
                            Crear cuenta
                        </a>
                    @else
                        <a href="{{ url('/contacto') }}" class="px-6 py-3 bg-[#FBB03B] hover:bg-[#e89a17] text-[#0B1220] rounded-xl font-semibold shadow transition">
                            Contacto
                        </a>
                    @endif

                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-white hover:bg-white/90 text-[#0B1220] rounded-xl font-semibold border shadow transition">
                            Ya tengo cuenta
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="px-6 py-3 bg-white hover:bg-white/90 text-[#0B1220] rounded-xl font-semibold border shadow transition">
                            Volver al inicio
                        </a>
                    @endif
                </div>
                <p class="text-xs text-white/80 mt-4">* Esta es una página de demostración. Los precios pueden variar.</p>
            </div>
        </section>
    </section>

</div>
@endsection
