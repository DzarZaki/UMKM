<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    GaleriController,
    ContactController,
    PortfolioController,
    ReservasiController,
    HomeController,
    KalenderController,
    KalenderMirrorController,
    PemesananController
};

/*
|--------------------------------------------------------------------------
| HALAMAN DEPAN (PUBLIC)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

// Portfolio (Public)
Route::prefix('portfolio')->name('portfolio.')->group(function () {
    Route::get('/prewedding', [PortfolioController::class, 'prewedding'])->name('prewedding');
    Route::get('/wedding',    [PortfolioController::class, 'wedding'])->name('wedding');
    Route::get('/wisuda',     [PortfolioController::class, 'wisuda'])->name('wisuda');
    Route::get('/lamaran',    [PortfolioController::class, 'lamaran'])->name('lamaran');
});

// Booking dari Home (Public)
Route::get('/booking', [PemesananController::class, 'create'])
    ->name('booking.form');

Route::post('/booking', [PemesananController::class, 'store'])
    ->name('booking.store');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authentication']);
});

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

    /*
    |--------------------------------------------------------------------------
    | GALERI (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('galeri', GaleriController::class);

    /*
    |--------------------------------------------------------------------------
    | RESERVASI
    |--------------------------------------------------------------------------
    */
    Route::resource('reservasi', ReservasiController::class);

    /*
    |--------------------------------------------------------------------------
    | PEMESANAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pemesanan', [PemesananController::class, 'index'])
        ->name('pemesanan.index');

    Route::patch('/pemesanan/{id}/status', [PemesananController::class, 'updateStatus'])
        ->name('pemesanan.status');

    /*
    |--------------------------------------------------------------------------
    | KALENDER (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::prefix('kalender')->group(function () {
        Route::get('/load',   [KalenderController::class, 'load']);
        Route::post('/store', [KalenderController::class, 'store']);
        Route::post('/update',[KalenderController::class, 'update']);
        Route::post('/delete',[KalenderController::class, 'destroy']);
    });

});

/*
    |--------------------------------------------------------------------------
    | KALENDER MIRROR (PUBLIC)
    |--------------------------------------------------------------------------
    */

    Route::get('/booking/kalender', [KalenderMirrorController::class, 'index'])
    ->name('booking.kalender');

// endpoint JSON untuk FullCalendar ambil data booked
Route::get('/booking/kalender/events', [KalenderMirrorController::class, 'events'])
    ->name('booking.kalender.events')
    ->middleware('throttle:60,1'); // optional biar tidak dibanjiri request
