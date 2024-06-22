<?php

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/likes', [RestauranteController::class, 'like'])->name('restaurantes.like');
    Route::post('/dislikes', [RestauranteController::class, 'unlike'])->name('restaurantes.unlike');
});
