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
    Route::get('/calendar/events', [ReservasiKalenderController::class, 'events'])
        ->name('calendar.events');
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


    Route::get('/reservasi/export', [ReservasiController::class, 'export'])
    ->name('reservasi.export');

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

    // EXPORT
    Route::get('/reservasi/export/pdf', [ReservasiController::class, 'exportPdf'])
        ->name('reservasi.export.pdf');

    Route::get('/reservasi/export/excel', [ReservasiController::class, 'exportExcel'])
        ->name('reservasi.export.excel');

    Route::resource('fotografer', \App\Http\Controllers\FotograferController::class)
    ->except(['show','create','edit']);


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

    // 🔑 AMBIL DATA FOTOGRAFER DARI USER LOGIN
    $fotograferModel = Fotografer::where('user_id', $user->id)->first();

    // 🚨 JIKA USER BELUM TERHUBUNG KE FOTOGRAFER
    if (!$fotograferModel) {
        abort(403, 'Akun fotografer belum terhubung ke data fotografer.');
    }

    $idFotografer = $fotograferModel->id;

    // LIST RESERVASI KHUSUS FOTOGRAFER
    $reservasi_list = Reservasi::where('id_fotografer', $idFotografer)
        ->latest()
        ->limit(30)
        ->get();

    // STATISTIK KHUSUS FOTOGRAFER
    $stats = [
        'assigned' => Reservasi::where('id_fotografer', $idFotografer)->count(),
        'done' => Reservasi::where('id_fotografer', $idFotografer)
                    ->where('status', 'done')
                    ->count(),
    ];

    // dropdown fotografer disembunyikan
    $fotografer = collect();

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
