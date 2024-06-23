<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Models\Restaurante;
use App\Models\Like;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/menu', function () {
    $restaurantes = Restaurante::where('user_id' ,'!=', auth()->id())->get();
    $likes = Like::all();
    $totalUsers = User::count()-1;
    $reviews = Review::whereIn('restaurante_id', $restaurantes->pluck('id'))->get();
    return Inertia::render('Dashboard', ['restaurantes' => $restaurantes, 'likes' => $likes, 'totalUsers' => $totalUsers,  'reviews' => $reviews]);
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

require __DIR__.'/likes.php';

require __DIR__.'/reviews.php';


