<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\{
    Fotografer,
    Reservasi
};
use App\Http\Controllers\{
    LoginController,
    GaleriController,
    ContactController,
    PortfolioController,
    ReservasiController,
    HomeController,
    KalenderController,
    KalenderMirrorController,
    PemesananController,
    ReservasiKalenderController
};

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::prefix('portfolio')->name('portfolio.')->group(function () {
    Route::get('/prewedding', [PortfolioController::class, 'prewedding'])->name('prewedding');
    Route::get('/wedding',    [PortfolioController::class, 'wedding'])->name('wedding');
    Route::get('/wisuda',     [PortfolioController::class, 'wisuda'])->name('wisuda');
    Route::get('/lamaran',    [PortfolioController::class, 'lamaran'])->name('lamaran');
});

Route::get('/booking', [PemesananController::class, 'create'])->name('booking.form');
Route::post('/booking', [PemesananController::class, 'store'])->name('booking.store');

Route::get('/booking/availability', [PemesananController::class, 'availability'])
    ->name('booking.availability')
    ->middleware('throttle:60,1');

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
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:admin'])->group(function () {

    Route::get('/dashboard', function (Request $request) {

        $status = $request->query('status');

        $reservasiQuery = Reservasi::query()->latest();

        if ($status) {
            $reservasiQuery->where('status', $status);
        } else {
            $reservasiQuery->where('status', '!=', 'new');
        }

        $reservasi_list = $reservasiQuery->limit(30)->get();
        $fotografer = Fotografer::orderBy('nama_fotografer')->get();

        $stats = [
            'new'         => Reservasi::where('status','new')->count(),
            'pending'     => Reservasi::where('status','pending')->count(),
            'in_progress' => Reservasi::where('status','in_progress')->count(),
            'done'        => Reservasi::where('status','done')->count(),
        ];

        return view('dashboard', compact(
            'reservasi_list',
            'fotografer',
            'stats'
        ));
    })->name('dashboard');

    Route::resource('galeri', GaleriController::class);
    Route::resource('reservasi', ReservasiController::class);

    Route::prefix('reservasi')->group(function () {
        Route::post('/store', [ReservasiController::class, 'storeJson']);
        Route::post('/update', [ReservasiController::class, 'updateJson']);
        Route::post('/update-time', [ReservasiController::class, 'updateTime']);
        Route::post('/delete', [ReservasiController::class, 'deleteJson']);
    });

    Route::prefix('kalender')->group(function () {
        Route::get('/load',   [KalenderController::class, 'load']);
        Route::post('/store', [KalenderController::class, 'store']);
        Route::post('/update',[KalenderController::class, 'update']);
        Route::post('/delete',[KalenderController::class, 'destroy']);
    });

    Route::get('/calendar/events', [ReservasiKalenderController::class, 'events'])
        ->name('calendar.events');

    // EXPORT
    Route::get('/reservasi/export/pdf', [ReservasiController::class, 'exportPdf'])
        ->name('reservasi.export.pdf');

    Route::get('/reservasi/export/excel', [ReservasiController::class, 'exportExcel'])
        ->name('reservasi.export.excel');

});

/*
|--------------------------------------------------------------------------
| FOTOGRAFER / VIDEOGRAFER DASHBOARD  ✅ DI LUAR ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth',
    'checkRole:fotografer,videografer,fotografer_videografer'
])->group(function () {

    Route::get('/dashboard-fotografer', function () {

        $user = auth()->user();

        $reservasi_list = Reservasi::where('id_fotografer', $user->id)
            ->latest()
            ->limit(30)
            ->get();

        $stats = [];        // sementara kosong
        $fotografer = collect(); // dropdown disembunyikan

        return view('dashboard', compact(
            'reservasi_list',
            'fotografer',
            'stats'
        ));
    })->name('dashboard.fotografer');
});

/*
|--------------------------------------------------------------------------
| KALENDER MIRROR (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/booking/kalender', [KalenderMirrorController::class, 'index'])
    ->name('booking.kalender');

Route::get('/booking/kalender/events', [KalenderMirrorController::class, 'events'])
    ->name('booking.kalender.events')
    ->middleware('throttle:60,1');
