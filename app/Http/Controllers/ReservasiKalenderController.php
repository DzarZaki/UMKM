<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservasiKalenderController extends Controller
{
    public function events(Request $request)
    {
        $tz = config('app.timezone', 'Asia/Jakarta');

        $start = $request->query('start');
        $end   = $request->query('end');

        $startDate = $start
            ? Carbon::parse($start, $tz)->toDateString()
            : now($tz)->startOfMonth()->toDateString();

        // end exclusive (FullCalendar)
        $endDate = $end
            ? Carbon::parse($end, $tz)->toDateString()
            : now($tz)->addMonth()->startOfMonth()->toDateString();

        $query = Reservasi::query()
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<', $endDate);

        /*
        |--------------------------------------------------------------------------
        | ROLE FILTER (INI KUNCI UTAMA)
        |--------------------------------------------------------------------------
        */
        if (auth()->check()) {
            $user = auth()->user();

            // kalau fotografer / videografer → batasi data
            if (in_array($user->role, ['fotografer','videografer','fotografer_videografer'])) {
                $query->where('id_fotografer', $user->id);
            }
        }

        // default: jangan tampilkan NEW
        if (!$request->boolean('include_new')) {
            $query->where('status', '!=', 'new');
        }

        // optional filters (ADMIN)
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('tipe_paket')) {
            $query->where('tipe_paket', $request->string('tipe_paket'));
        }

        if ($request->filled('id_fotografer')) {
            $query->where('id_fotografer', $request->integer('id_fotografer'));
        }

        $events = $query->get()->map(function ($r) use ($tz) {
            $start = Carbon::parse($r->tanggal.' '.$r->waktu_mulai, $tz)->format('Y-m-d\TH:i:s');
            $end   = Carbon::parse($r->tanggal.' '.$r->waktu_selesai, $tz)->format('Y-m-d\TH:i:s');

            return [
                'id'    => (string) $r->id,
                'title' => trim($r->nama.' - '.($r->tipe_paket ?? '')),
                'start' => $start,
                'end'   => $end,
                'classNames' => ['status-'.$r->status],
                'extendedProps' => [
                    'nama' => $r->nama,
                    'email' => $r->email,
                    'no_hp' => $r->no_hp,
                    'tipe_paket' => $r->tipe_paket,
                    'keterangan' => $r->keterangan,
                    'status' => $r->status,
                    'id_fotografer' => $r->id_fotografer,
                ],
            ];
        });

        return response()->json($events);
    }
}
