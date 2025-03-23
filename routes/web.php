<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/new', [DashboardController::class, 'create'])->name('bookmark.create');
    Route::post('/new', [DashboardController::class, 'store'])->name('bookmark.store');
    Route::delete('/delete/{bookmark}', [DashboardController::class, 'destroy'])->name('bookmark.destroy');

    // add to fav
    Route::get('/favorite/{bookmark}', [DashboardController::class, 'favorite'])->name('bookmark.favorite');
    // remove from fav
    Route::get('/unfavorite/{bookmark}', [DashboardController::class, 'unfavorite'])->name('bookmark.unfavorite');
});
