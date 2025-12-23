<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\{
    Fotografer,
    Reservasi};
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
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'checkRole:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function (Request $request) {
    $status = $request->query('status');

    // LIST KANAN
    $reservasiQuery = Reservasi::query()->latest();

    if ($status) {
      $reservasiQuery->where('status', $status);
    } else {
      $reservasiQuery->where('status', '!=', 'new'); // optional default
    }

    $reservasi_list = $reservasiQuery->limit(30)->get(); // LIMIT QUERY DI DASHBOARD

    // DROPDOWN fotografer modal
    $fotografer = Fotografer::orderBy('nama_fotografer')->get();

    
    $stats = [
      'new'         => Reservasi::where('status','new')->count(),
      'pending'     => Reservasi::where('status','pending')->count(),
      'in_progress' => Reservasi::where('status','in_progress')->count(),
      'done'        => Reservasi::where('status','done')->count(),
    ];

    return view('dashboard', compact('reservasi_list', 'fotografer', 'status', 'stats'));
    })->name('dashboard');

    /*
|--------------------------------------------------------------------------
| FOTOGRAFER / NON ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:fotografer,videografer,fotografer_videografer'])
->group(function () {

    Route::get('/dashboard-fotografer', function (Request $request) {

        $user = auth()->user();

        // ambil id fotografer (samakan dengan struktur DB kamu)
        $idFotografer = $user->id;

        // LIST RESERVASI KHUSUS FOTOGRAFER LOGIN
        $reservasi_list = Reservasi::where('id_fotografer', $idFotografer)
            ->latest()
            ->limit(30)
            ->get();

        // STATISTIK → KOMEN DULU
        $stats = [
            // 'new' => 0,
            // 'pending' => 0,
            // 'in_progress' => 0,
            // 'done' => 0,
        ];

        // dropdown fotografer DISEMBUNYIKAN
        $fotografer = collect(); // kosong

        return view('dashboard', compact(
            'reservasi_list',
            'fotografer',
            'stats'
        ));
    })->name('dashboard.fotografer');

});


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
    Route::prefix('reservasi')->group(function () {
        Route::post('/store', [ReservasiController::class, 'storeJson']);
        Route::post('/update', [ReservasiController::class, 'updateJson']);
        Route::post('/update-time', [ReservasiController::class, 'updateTime']);
        Route::post('/delete', [ReservasiController::class, 'deleteJson']);
    });


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

    Route::get('/calendar/events', [ReservasiKalenderController::class, 'events'])
  ->name('calendar.events');


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
