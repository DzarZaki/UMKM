<?php
namespace App\Http\Controllers;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class KalenderMirrorController extends Controller
{
    public function index()
    {
        return view('booking.kalender');
    }

    public function events(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        $q = Reservasi::query()
            ->select(['id', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'status'])
            ->whereDate('tanggal', '>=', now()->toDateString())
            ->whereIn('status', ['pending','in_progress','done']); // ✅ jangan tampilkan new

        if ($start && $end) {
            $q->whereBetween('tanggal', [
                substr($start, 0, 10),
                substr($end, 0, 10),
            ]);
        }

        $items = $q->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        $events = $items->map(fn ($r) => [
            'id'    => (string) $r->id,
            'title' => 'Booked',
            'start' => $r->tanggal . 'T' . $r->waktu_mulai,
            'end'   => $r->tanggal . 'T' . $r->waktu_selesai,
        ]);

        return response()->json($events);
    }
}
