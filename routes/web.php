<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/quienes-somos', [PagesController::class, 'about'])->name('about');
Route::get('/faq',            [PagesController::class, 'faq'])->name('faq');
Route::get('/mapa',           [PagesController::class, 'map'])->name('map');
Route::get('/familias-reunidas', [PagesController::class, 'reunions'])->name('reunions');
Route::get('/precios',        [PagesController::class, 'pricing'])->name('pricing');
