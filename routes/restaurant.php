<?php

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');
    Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
    Route::put('/restaurantes/{restaurante}', [RestauranteController::class, 'update'])->name('restaurantes.update');
});
