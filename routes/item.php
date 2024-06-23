<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::post('/items/{item}', [ItemController::class, 'update'])->name('items.update');
});
