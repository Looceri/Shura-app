<?php

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');
    Route::get('/favoritos', [RestauranteController::class, 'favoritos'])->name('restaurantes.favoritos');
    Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
    Route::post('/restaurantes/{restaurante}', [RestauranteController::class, 'update'])->name('restaurantes.update');
});
