<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;


Route::middleware('auth')->group(function () {

    Route::get('/restaurante', [RestaurantController::class, 'index'])->name('restaurante.traz');

});
