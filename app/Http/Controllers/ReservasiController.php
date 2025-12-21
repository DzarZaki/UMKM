<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Kalender;
use App\Models\User;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi
     */
    public function index()
    {
        $reservasi = Reservasi::latest()->get();
        return view('reservasi.index', compact('reservasi'));
    }

    /**
     * Tampilkan form tambah reservasi
     */
    public function create()
    {
        // Ambil user dengan role fotografer / videografer / keduanya
        $fotografer = User::whereIn('role', [
            'fotografer',
            'videografer',
            'fotografer_videografer'
        ])->get();

        $kalender = Kalender::all();

        return view('reservasi.create', compact('fotografer', 'kalender'));
    }

    /**
     * Simpan data reservasi
     */
    public function store(Request $request)
{
    $request->validate([
        'nama'        => 'required|string|max:255',
        'email'       => 'required|email',
        'no_hp'       => 'required|string|max:20',
        'tipe_paket'  => 'nullable|string|max:255',
        'tanggal'     => 'required|date',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required|after:waktu_mulai',
        'keterangan'  => 'nullable|string',

        'id_fotografer' => 'nullable|exists:users,id',
        'id_kalender'   => 'nullable|exists:kalender,id',
        'status'        => 'required|in:pending,in_progress,done',
    ]);

    Reservasi::create($request->all());

    return redirect()
        ->route('reservasi.index')
        ->with('success', 'Reservasi berhasil ditambahkan');
}


    /**
     * Tampilkan form edit reservasi
     */
    public function edit($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $fotografer = User::whereIn('role', [
            'fotografer',
            'videografer',
            'fotografer_videografer'
        ])->get();

        $kalender = Kalender::all();

        return view('reservasi.edit', compact('reservasi', 'fotografer', 'kalender'));
    }

    /**
     * Update data reservasi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_fotografer'    => 'required|exists:users,id',
            'id_kalender'      => 'required|exists:kalender,id',
            'nama_klien'       => 'required|string|max:255',
            'email'            => 'required|email',
            'tanggal'          => 'required|date',
            'status_reservasi' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update($request->only([
            'id_fotografer',
            'id_kalender',
            'nama_klien',
            'email',
            'tanggal',
            'status_reservasi'
        ]));

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Reservasi berhasil diperbarui');
    }

    /**
     * Hapus reservasi
     */
    public function destroy($id)
    {
        Reservasi::findOrFail($id)->delete();

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dihapus');
    }
}
