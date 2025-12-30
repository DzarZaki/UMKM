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
        |------------------------------------------------------------------
        | ROLE FILTER (FINAL & BENAR)
        |------------------------------------------------------------------
        */
        if (auth()->check()) {
            $user = auth()->user();

            if (in_array($user->role, [
                'fotografer',
                'videografer',
                'fotografer_videografer'
            ])) {
                $query->where('user_id', $user->id);
            }
        }

        // default: jangan tampilkan NEW
        if (!$request->boolean('include_new')) {
            $query->where('status', '!=', 'new');
        }

        // filter status (ADMIN)
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('tipe_paket')) {
            $query->where('tipe_paket', $request->string('tipe_paket'));
        }

        // 🔑 FILTER FOTOGRAFER (USER ID)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        $events = $query->get()->map(function ($r) use ($tz) {
            $start = Carbon::parse($r->tanggal.' '.$r->waktu_mulai, $tz)
                        ->format('Y-m-d\TH:i:s');

            $end   = Carbon::parse($r->tanggal.' '.$r->waktu_selesai, $tz)
                        ->format('Y-m-d\TH:i:s');

            return [
                'id'    => (string) $r->id,
                'title' => trim($r->nama.' - '.($r->tipe_paket ?? '')),
                'start' => $start,
                'end'   => $end,
                'classNames' => ['status-'.$r->status],

                // ⬇️ INI KUNCI FRONTEND
                'extendedProps' => [
                    'nama'       => $r->nama,
                    'email'      => $r->email,
                    'no_hp'      => $r->no_hp,
                    'tipe_paket' => $r->tipe_paket,
                    'keterangan' => $r->keterangan,
                    'status'     => $r->status,

                    // FINAL
                    'user_id'    => $r->user_id,
                ],
            ];
        });

        return response()->json($events);
    }
}
