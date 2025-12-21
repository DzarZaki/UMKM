<?php

namespace App\Http\Controllers;

use App\Models\Kalender;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KalenderController extends Controller
{
    // Load FullCalendar
    public function load()
    {
        return Kalender::selectRaw("
            id as id,
            nama_klien as title,
            CONCAT(tanggal, 'T', waktu_mulai) as start,
            CONCAT(tanggal, 'T', waktu_selesai) as end,
            nomor_hp,
            email
        ")->get();
    }

    // Create & Update (dari modal)
    public function store(Request $request)
    {
        // minimal validation (biar gak nyimpen kosong)
        $request->validate([
            'user_id' => ['required', 'integer'],
            'nama_klien' => ['required', 'string'],
            'nomor_hp' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'tanggal' => ['required', 'date'],
            'waktu_mulai' => ['required'],
            'waktu_selesai' => ['required'],
        ]);

        Kalender::updateOrCreate(
            ['id' => $request->id_kalender], // PK = id
            [
                'user_id'       => $request->user_id,
                'nama_klien'    => $request->nama_klien,
                'nomor_hp'      => $request->nomor_hp,
                'email'         => $request->email,
                'tanggal'       => $request->tanggal,
                'waktu_mulai'   => $request->waktu_mulai,   // format: HH:MM:SS
                'waktu_selesai' => $request->waktu_selesai, // format: HH:MM:SS
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    // Drag / Resize (dari FullCalendar: start/end ISO datetime)
    public function update(Request $request)
{
    $request->validate([
        'id' => ['required','integer'],
        'tanggal' => ['required','date'],
        'waktu_mulai' => ['required'],
        'waktu_selesai' => ['required'],
    ]);

    Kalender::where('id', $request->id)->update([
        'tanggal'       => $request->tanggal,
        'waktu_mulai'   => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
    ]);

    return response()->json(['status' => 'updated']);
}



    // Delete
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        Kalender::where('id', $request->id)->delete();

        return response()->json(['status' => 'deleted']);
    }
}
