<?php

namespace App\Http\Controllers;

use App\Models\Kalender;
use Illuminate\Http\Request;

class KalenderMirrorController extends Controller
{
    public function index()
    {
        return view('booking.kalender');
    }

    public function events(Request $request)
    {
        // FullCalendar biasanya kirim start & end (ISO string)
        $start = $request->query('start'); // contoh: 2025-12-21T00:00:00Z
        $end   = $request->query('end');

        $q = Kalender::query()
            ->select(['id', 'tanggal', 'waktu_mulai', 'waktu_selesai'])
            ->whereDate('tanggal', '>=', now()->toDateString()); // hanya dari hari ini ke depan

        // Filter range biar tidak load semua data
        if ($start && $end) {
            $q->whereBetween('tanggal', [
                substr($start, 0, 10),
                substr($end, 0, 10),
            ]);
        }

        $items = $q->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        // PENTING: untuk klien, JANGAN kirim nama/email/no_hp
        $events = $items->map(fn ($k) => [
            'id'    => $k->id,
            'title' => 'Booked',
            'start' => $k->tanggal . 'T' . $k->waktu_mulai,
            'end'   => $k->tanggal . 'T' . $k->waktu_selesai,
        ]);

        return response()->json($events);
    }
}
