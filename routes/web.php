<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReservasiController;


// Halaman Depan
Route::get('/', [GaleriController::class, 'tampilanHome'])->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authentication']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Grup Admin
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // MODE RESOURCE LENGKAP
    Route::resource('galeri', GaleriController::class);

     //RESERVASI
    Route::resource('reservasi', ReservasiController::class);
});

//prewed
Route::get('/portfolio/prewedding', [GaleriController::class, 'prewedding']);
Route::get('/portfolio/wedding', [GaleriController::class, 'wedding']);

Route::get('/portfolio/prewedding', [PortfolioController::class, 'prewedding'])
    ->name('portfolio.prewedding');

Route::get('/portfolio/wedding', [PortfolioController::class, 'wedding'])
    ->name('portfolio.wedding');



