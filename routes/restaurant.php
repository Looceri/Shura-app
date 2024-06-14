<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController; // Add this import statement

Route::middleware('auth')->group(function () {

    Route::get('/restaurante', [RestauranteController::class, 'index'])->name('restaurante.crud');

});
