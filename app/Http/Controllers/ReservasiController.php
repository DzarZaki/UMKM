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
            'id_fotografer'    => 'required|exists:users,id',
            'id_kalender'      => 'required|exists:kalender,id',
            'nama_klien'       => 'required|string|max:255',
            'email'            => 'required|email',
            'tanggal'          => 'required|date',
            'status_reservasi' => 'required|in:pending,confirmed,cancelled',
        ]);

        Reservasi::create([
            'id_fotografer'    => $request->id_fotografer,
            'id_kalender'      => $request->id_kalender,
            'nama_klien'       => $request->nama_klien,
            'email'            => $request->email,
            'tanggal'          => $request->tanggal,
            'status_reservasi' => $request->status_reservasi,
        ]);

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
