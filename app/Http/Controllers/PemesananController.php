<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class PemesananController extends Controller
{   
    public function availability(Request $request)
    {
        $tanggal = $request->query('tanggal');
        if (!$tanggal) {
            return response()->json(['ok' => false], 422);
        }

        $capacity = 10;

        // hitung booking yang dianggap "mengunci slot" (bukan new)
        $booked = Reservasi::whereDate('tanggal', $tanggal)
            ->whereIn('status', ['pending','in_progress','done'])
            ->count();

        $remaining = max(0, $capacity - $booked);

        // level + pesan
        if ($remaining <= 0) {
            $level = 'full';
            $title = 'Slot penuh';
            $desc  = "Tanggal yang dipilih sudah penuh. Tapi, admin akan cek ketersediaan manual.";
        } elseif ($remaining <= 2) {
            $level = 'low';
            $title = 'Ketersediaan terbatas';
            $desc  = "Tersisa sedikit slot untuk tanggal ini.";
        } else {
            $level = 'ok';
            $title = 'Masih tersedia';
            $desc  = "Masih ada slot untuk tanggal ini.";
        }

        return response()->json([
            'ok' => true,
            'tanggal' => $tanggal,
            'capacity' => $capacity,
            'booked' => $booked,
            'remaining' => $remaining,
            'level' => $level,
            'title' => $title,
            'desc' => $desc,
        ]);
    }

    // FORM BOOKING (PUBLIC)
    public function create()
    {
        return view('booking');
    }

    // SIMPAN BOOKING
    public function store(Request $request)
    {
    // 1) Honeypot
    if ($request->filled('website')) {
        abort(422);
    }

    // 2) Minimum time submit
    $ts = (int) $request->input('_ts', 0);
    if (!$ts || (time() - $ts) < 4) {
        abort(429);
    }

    $data = $request->validate([
        'nama'          => ['required','string','min:3','max:255'],
        'email'         => ['required','email','max:255'],
        'no_hp'         => ['required','string','regex:/^[0-9+]{9,15}$/','max:20'],
        'tipe_paket'    => ['nullable','string','max:100'],
        'tanggal'       => ['required','date','after_or_equal:today'],
        'waktu_mulai'   => ['required','date_format:H:i'],
        'waktu_selesai' => ['required','date_format:H:i','after:waktu_mulai'],
        'keterangan'    => ['nullable','string','max:1000'],
        'waiting_list'  => ['nullable','boolean'], 

        // honeypot / anti spam (nilai plus)
        'website'       => 'nullable|size:0',
    ]);

    // normalisasi waktu -> H:i:s
    $mulai  = $data['waktu_mulai'] . ':00';
    $selesai = $data['waktu_selesai'] . ':00';

    // ✅ keterangan final (+tag waiting list kalau dicentang)
    $keteranganFinal = trim($request->input('keterangan', ''));;

    if ($request->boolean('waiting_list')) {
        $tag = "[WAITING LIST] Mohon dihubungi jika ada slot kosong/cancel di tanggal ini.";
        $keteranganFinal = trim(($keteranganFinal ? $keteranganFinal . "\n" : '') . $tag);
    }


    // 3) Anti duplikat (cek sebelum insert)
    $exists = Reservasi::where('email', $data['email'])
        ->where('tanggal', $data['tanggal'])
        ->where('waktu_mulai', $mulai)
        ->whereIn('status', ['new','pending','in_progress'])
        ->exists();

    if ($exists) {
        return back()->with(
            'success',
            "Admin kami akan menghubungi Anda melalui WhatsApp atau Email yang diberikan."
        );
    }

   Reservasi::create([
    'user_id'       => null, // BELUM DITUGASKAN KE FOTOGRAFER
    'nama'          => $data['nama'],
    'email'         => $data['email'],
    'no_hp'         => $data['no_hp'],
    'tipe_paket'    => $data['tipe_paket'] ?? null,
    'tanggal'       => $data['tanggal'],
    'waktu_mulai'   => $mulai,
    'waktu_selesai' => $selesai,
    'keterangan'    => $keteranganFinal,
    'status'        => 'new',
]);


    return back()->with(
        'success',
        "Admin kami akan menghubungi Anda melalui email atau nomor HP yang diberikan."
    );

    }
}