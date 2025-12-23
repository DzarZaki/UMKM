<?php

namespace App\Http\Controllers;

use App\Models\Fotografer;
use App\Models\Reservasi;
use App\Models\Kalender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi
     */
    public function index(Request $request)
{
    $query = Reservasi::query()->latest();

    if ($request->filled('status')) {
        $query->where('status', $request->string('status'));
    }

    if ($request->filled('tipe_paket')) {
        $query->where('tipe_paket', $request->string('tipe_paket'));
    }

    if ($request->filled('q')) {
        $q = $request->string('q');
        $query->where(function ($sub) use ($q) {
            $sub->where('nama', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('no_hp', 'like', "%{$q}%");
        });
    }

    // kalau mau pagination:
    $reservasi = $query->paginate(20)->withQueryString();

    $paketOptions = Reservasi::query()
        ->whereNotNull('tipe_paket')
        ->where('tipe_paket', '!=', '')
        ->distinct()
        ->orderBy('tipe_paket')
        ->pluck('tipe_paket');

    // dropdown modal harus dari tabel fotografer & kalender
    $fotografer = Fotografer::orderBy('nama_fotografer')->get();
    $kalender   = Kalender::orderBy('tanggal')->orderBy('waktu_mulai')->get();

    return view('reservasi.index', compact('reservasi', 'paketOptions', 'fotografer', 'kalender'));
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

        'id_fotografer' => 'nullable|exists:fotografer,id',
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
            'id_fotografer'    => 'required|exists:fotografer,id',
            'id_kalender'      => 'required|exists:kalender,id',
            'nama'       => 'required|string|max:255',
            'email'            => 'required|email',
            'tanggal'          => 'required|date',
            'status' => 'required|in:new,pending,in_progress,done',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update($request->only([
            'id_fotografer',
            'id_kalender',
            'nama',
            'email',
            'tanggal',
            'status'
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

    //kalender
    public function storeJson(Request $request)
    {
        $data = $request->validate([
            'id_fotografer' => ['nullable', 'integer', Rule::exists('fotografer', 'id')],
            'id_kalender'     => ['nullable', 'integer', 'exists:kalender,id'],

            'nama'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'no_hp'           => ['required', 'string', 'max:20'],
            'tipe_paket'      => ['nullable', 'string', 'max:255'],

            'tanggal'         => ['required', 'date'],
            'waktu_mulai'     => ['required', 'date_format:H:i:s'],
            'waktu_selesai'   => ['required', 'date_format:H:i:s', 'after:waktu_mulai'],

            'keterangan'      => ['nullable', 'string'],
            'status'          => ['required', Rule::in(['new','pending','in_progress','done'])]
        ]);

    $reservasi = Reservasi::create($data);

        return response()->json([
            'ok' => true,
            'data' => $reservasi,
        ], 201);
    }

public function updateJson(Request $request)
    {
    $data = $request->validate([
        'id'              => ['required', 'integer', 'exists:reservasi,id'],

        'id_fotografer' => ['nullable', 'integer', Rule::exists('fotografer', 'id')],
        'id_kalender'     => ['nullable', 'integer', 'exists:kalender,id'],

        'nama'            => ['required', 'string', 'max:255'],
        'email'           => ['required', 'email', 'max:255'],
        'no_hp'           => ['required', 'string', 'max:20'],
        'tipe_paket'      => ['nullable', 'string', 'max:255'],

        'tanggal'         => ['required', 'date'],
        'waktu_mulai'     => ['required', 'date_format:H:i:s'],
        'waktu_selesai'   => ['required', 'date_format:H:i:s', 'after:waktu_mulai'],

        'keterangan'      => ['nullable', 'string'],
        'status'          => ['required', Rule::in(['new','pending','in_progress','done'])],
    ]);

        $reservasi = Reservasi::findOrFail($data['id']);
        unset($data['id']);

        $reservasi->update($data);

        return response()->json([
            'ok' => true,
            'data' => $reservasi,
        ]);
    }

public function updateTime(Request $request)
{
    $data = $request->validate([
        'id'            => ['required', 'integer', 'exists:reservasi,id'],
        'tanggal'       => ['required', 'date'],
        'waktu_mulai'   => ['required', 'date_format:H:i:s'],
        'waktu_selesai' => ['required', 'date_format:H:i:s', 'after:waktu_mulai'],
    ]);

    $reservasi = Reservasi::findOrFail($data['id']);
    $reservasi->update([
        'tanggal' => $data['tanggal'],
        'waktu_mulai' => $data['waktu_mulai'],
        'waktu_selesai' => $data['waktu_selesai'],
    ]);

    return response()->json(['ok' => true]);
}

public function deleteJson(Request $request)
{
    $data = $request->validate([
        'id' => ['required', 'integer', 'exists:reservasi,id'],
    ]);

    Reservasi::where('id', $data['id'])->delete();

    return response()->json(['ok' => true]);
}

}
