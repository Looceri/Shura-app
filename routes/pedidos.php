<?php

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/pedidos', [RestauranteController::class, 'criarPedido'])->name('pedidos.store');
});
