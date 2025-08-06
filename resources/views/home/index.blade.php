@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">🐾 Mascotas Perdidas / Encontradas</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($mascotas as $mascota)
            <div class="bg-white shadow rounded p-4">
                <img src="{{ $mascota['foto'] }}" alt="Mascota" class="w-full h-48 object-cover rounded">
                <h2 class="text-xl font-semibold mt-2">{{ $mascota['nombre'] }}</h2>
                <p class="text-sm text-gray-600">{{ $mascota['ubicacion'] }}</p>
                <p class="text-sm mt-1">{{ $mascota['descripcion'] }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
