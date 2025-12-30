<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Reservasi;
use App\Models\User;

use App\Http\Controllers\{
    LoginController,
    GaleriController,
    PortfolioController,
    ReservasiController,
    HomeController,
    KalenderMirrorController,
    PemesananController,
    ReservasiKalenderController,
    FotograferController
};

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

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

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/calendar/events', [ReservasiKalenderController::class, 'events'])
        ->name('calendar.events');
});

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:admin'])->group(function () {

    /*
    | DASHBOARD ADMIN
    */
    Route::get('/dashboard', function (Request $request) {

        $status = $request->query('status');

        $reservasiQuery = Reservasi::latest();

        if ($status) {
            $reservasiQuery->where('status', $status);
        } else {
            $reservasiQuery->where('status', '!=', 'new');
        }

        $reservasi_list = $reservasiQuery->limit(30)->get();

        // 🔑 FOTOGRAFER DIAMBIL DARI USERS
       $usersFotografer = User::whereIn('role', [
    'fotografer',
    'videografer',
    'fotografer_videografer'
])->orderBy('username')->get();


        $stats = [
            'new'         => Reservasi::where('status','new')->count(),
            'pending'     => Reservasi::where('status','pending')->count(),
            'in_progress' => Reservasi::where('status','in_progress')->count(),
            'done'        => Reservasi::where('status','done')->count(),
        ];

        return view('dashboard', compact(
    'reservasi_list',
    'usersFotografer',
    'stats'
));
    })->name('dashboard');

    /*
    | GALERI & RESERVASI
    */
    Route::resource('galeri', GaleriController::class);
    Route::resource('reservasi', ReservasiController::class);

    // 🔑 AJAX / MODAL RESERVASI
    Route::prefix('reservasi')->group(function () {
        Route::post('/store', [ReservasiController::class, 'storeJson']);
        Route::post('/update', [ReservasiController::class, 'updateJson']);
        Route::post('/update-time', [ReservasiController::class, 'updateTime']);
        Route::post('/delete', [ReservasiController::class, 'deleteJson']);
    });

    /*
    | EXPORT
    */
    Route::get('/reservasi/export', [ReservasiController::class, 'export'])
        ->name('reservasi.export');

    Route::get('/reservasi/export/excel', [ReservasiController::class, 'exportExcel'])
        ->name('reservasi.export.excel');
});

/*
|--------------------------------------------------------------------------
| FOTOGRAFER / VIDEOGRAFER DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth',
    'checkRole:fotografer,videografer,fotografer_videografer'
])->group(function () {

    Route::get('/dashboard-fotografer', function () {

        $user = auth()->user();

        // LIST RESERVASI KHUSUS USER LOGIN
        $reservasi_list = Reservasi::where('user_id', $user->id)
            ->latest()
            ->limit(20)
            ->get();

        $stats = [
            'assigned' => Reservasi::where('user_id', $user->id)->count(),
            'done'     => Reservasi::where('user_id', $user->id)
                            ->where('status', 'done')
                            ->count(),
        ];
        $usersFotografer = User::whereIn('role', [
    'fotografer',
    'videografer',
    'fotografer_videografer'
])->orderBy('username')->get();

        return view('dashboard', compact(
            'reservasi_list',
            'stats',
            'usersFotografer'
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

Route::middleware(['auth', 'checkRole:admin'])->group(function () {

    // === FOTOGRAFER (CRUD dari tabel users) ===
    Route::resource('fotografer', FotograferController::class);

});
