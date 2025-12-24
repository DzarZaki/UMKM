<?php

namespace App\Http\Controllers;

use App\Models\Fotografer;
use App\Models\User;
use Illuminate\Http\Request;

class FotograferController extends Controller
{
    public function index()
    {
        $fotografer = Fotografer::with('user')
            ->withCount('reservasi')
            ->orderBy('nama_fotografer')
            ->get();

        // user yg bisa dipilih (role fotografer / videografer / gabungan)
        $users = User::whereIn('role', [
            'fotografer',
            'videografer',
            'fotografer_videografer'
        ])->get();

        return view('fotografer.index', compact('fotografer', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id|unique:fotografer,user_id',
            'nama_fotografer'=> 'required|string|max:255',
            'spesialisasi'   => 'nullable|string|max:255',
        ]);

        Fotografer::create($request->all());

        return redirect()
            ->route('fotografer.index')
            ->with('success', 'Fotografer berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $fotografer = Fotografer::findOrFail($id);

        $request->validate([
            'nama_fotografer'=> 'required|string|max:255',
            'spesialisasi'   => 'nullable|string|max:255',
        ]);

        $fotografer->update($request->only([
            'nama_fotografer',
            'spesialisasi'
        ]));

        return redirect()
            ->route('fotografer.index')
            ->with('success', 'Fotografer berhasil diperbarui');
    }

    public function destroy($id)
    {
        Fotografer::findOrFail($id)->delete();

        return redirect()
            ->route('fotografer.index')
            ->with('success', 'Fotografer berhasil dihapus');
    }
}
