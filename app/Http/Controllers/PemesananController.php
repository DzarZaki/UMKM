<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    // FORM BOOKING (PUBLIC)
    public function create()
    {
        return view('booking');
    }

    // SIMPAN BOOKING
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email',
            'no_hp'         => 'required|string|max:20',
            'tipe_paket'    => 'nullable|string|max:100',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'keterangan'    => 'nullable|string',
        ]);

        Reservasi::create([
            'nama'        => $request->nama,
            'email'       => $request->email,
            'no_hp'       => $request->no_hp,
            'tipe_paket'  => $request->tipe_paket,
            'tanggal'     => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'keterangan'  => $request->keterangan,
            'status'      => 'pending',
        ]);


        return back()->with('success', 'Booking berhasil dikirim');
    }
}
