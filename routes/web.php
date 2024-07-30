<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\CoinUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::delete('/coins/{id}', [CoinController::class, 'destroy'])->name('coins.destroy');
    Route::get('/coins/all', [CoinController::class, 'allCoins']);

    Route::get('/user-coins', [CoinUserController::class, 'userCoins']);
    Route::post('/user-coins/add', [CoinUserController::class, 'addCoin']);
    Route::delete('/user-coins/{id}', [CoinUserController::class, 'removeCoin']);
});

require __DIR__.'/auth.php';

