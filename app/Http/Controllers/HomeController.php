<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $mascotas = [
            [
                'nombre' => 'Max',
                'ubicacion' => 'Guadalajara, Jalisco',
                'foto' => 'https://placedog.net/400?id=1',
                'descripcion' => 'Perro perdido, responde al nombre de Max.',
            ],
            [
                'nombre' => 'Luna',
                'ubicacion' => 'Zapopan, Jalisco',
                'foto' => 'https://placedog.net/400?id=2',
                'descripcion' => 'Gata encontrada cerca del parque.',
            ],
            // Agrega más si gustas
        ];

        return view('home.index', compact('mascotas'));
    }
}
