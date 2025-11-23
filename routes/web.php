<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GaleriController;

Route::get('/login', [LoginController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'authentication']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth');


// =================================================================
// SEMUA HALAMAN DI BAWAH HANYA UNTUK ADMIN YANG SUDAH LOGIN
// =================================================================
Route::middleware(['auth', 'checkRole:admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    // CRUD penuh galeri (admin only)
    Route::resource('/galeri', GaleriController::class);
});
