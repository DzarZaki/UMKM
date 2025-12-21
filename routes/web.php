<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| HALAMAN DEPAN (PUBLIC)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Portfolio (Public)
Route::prefix('portfolio')->group(function () {

    Route::get('/prewedding', [PortfolioController::class, 'prewedding'])
        ->name('portfolio.prewedding');

    Route::get('/wedding', [PortfolioController::class, 'wedding'])
        ->name('portfolio.wedding');

    Route::get('/wisuda', [PortfolioController::class, 'wisuda'])
        ->name('portfolio.wisuda');

    Route::get('/lamaran', [PortfolioController::class, 'lamaran'])
        ->name('portfolio.lamaran');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'authentication']);
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'checkRole:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Galeri (CRUD Admin)
    Route::resource('galeri', GaleriController::class);

    // Reservasi (CRUD Admin)
    Route::resource('reservasi', ReservasiController::class);
});
