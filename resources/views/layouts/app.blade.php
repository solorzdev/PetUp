<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold">🐶 Mascotas App</h1>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white mt-10 py-4 shadow-inner">
        <div class="text-center text-sm text-gray-500">© {{ date('Y') }} - Proyecto demo inspirado en SoyWako</div>
    </footer>
</body>
</html>
