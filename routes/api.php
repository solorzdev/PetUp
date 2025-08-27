<?php

use App\Http\Controllers\VeterinaryController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/veterinaries', [VeterinaryController::class, 'index']);
