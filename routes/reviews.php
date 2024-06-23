<?php

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/reviews', [RestauranteController::class, 'review'])->name('reviews');
    Route::post('/reviews', [RestauranteController::class, 'criarReview'])->name('restaurantes.review');
});
