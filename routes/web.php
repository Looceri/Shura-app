<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Models\Restaurante;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/menu', function () {
    $restaurantes = Restaurante::where('user_id','!=', auth()->id())->get();
    return Inertia::render('Dashboard', ['restaurantes' => $restaurantes]);
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('start');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

require __DIR__.'/restaurant.php';

require __DIR__.'/item.php';
