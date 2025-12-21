<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GaleriController extends Controller
{
    /**
     * ADMIN: daftar galeri
     */
    public function index()
    {
        $galeri = Galeri::latest()->get();
        return view('galeri.index', compact('galeri'));
    }

    /**
     * ADMIN: form tambah galeri
     */
    public function create()
    {
        return view('galeri.create');
    }

    /**
     * ADMIN: simpan galeri
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|max:255',
            'kategori'    => 'required|in:prewedding,wedding,wisuda,lamaran,featured',
            'file_galeri' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /**
         * RULE JUMLAH FOTO
         * - featured : max 1
         * - lainnya  : max 7
         */
        if ($request->kategori === 'featured') {
            $jumlah = Galeri::where('kategori', 'featured')->count();

            if ($jumlah >= 1) {
                return back()
                    ->withErrors([
                        'kategori' => 'Featured hanya boleh 1 foto'
                    ])
                    ->withInput();
            }
        } else {
            $jumlah = Galeri::where('kategori', $request->kategori)->count();

            if ($jumlah >= 7) {
                return back()
                    ->withErrors([
                        'kategori' => 'Maksimal 7 foto untuk kategori ini'
                    ])
                    ->withInput();
            }
        }

        // upload file
        $file = $request->file('file_galeri');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/galeri'), $namaFile);

        Galeri::create([
            'judul'       => $request->judul,
            'kategori'    => $request->kategori,
            'file_galeri' => $namaFile,
        ]);

        return redirect()
            ->route('galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan');
    }

    /**
     * ADMIN: form edit galeri
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('galeri.edit', compact('galeri'));
    }

    /**
     * ADMIN: update galeri
     */
    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul'       => 'required|max:255',
            'kategori'    => 'required|in:prewedding,wedding,wisuda,lamaran,featured',
            'file_galeri' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /**
         * Cegah featured lebih dari 1 (saat update)
         */
        if ($request->kategori === 'featured') {
            $jumlah = Galeri::where('kategori', 'featured')
                ->where('id', '!=', $galeri->id)
                ->count();

            if ($jumlah >= 1) {
                return back()
                    ->withErrors([
                        'kategori' => 'Featured hanya boleh 1 foto'
                    ])
                    ->withInput();
            }
        }

        if ($request->hasFile('file_galeri')) {
            $pathLama = public_path('uploads/galeri/' . $galeri->file_galeri);
            if (File::exists($pathLama)) {
                File::delete($pathLama);
            }

            $file = $request->file('file_galeri');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/galeri'), $namaFile);

            $galeri->file_galeri = $namaFile;
        }

        $galeri->judul    = $request->judul;
        $galeri->kategori = $request->kategori;
        $galeri->save();

        return redirect()
            ->route('galeri.index')
            ->with('success', 'Galeri berhasil diperbarui');
    }

    /**
     * ADMIN: hapus galeri
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        $path = public_path('uploads/galeri/' . $galeri->file_galeri);
        if (File::exists($path)) {
            File::delete($path);
        }

        $galeri->delete();

        return redirect()
            ->route('galeri.index')
            ->with('success', 'Galeri berhasil dihapus');
    }
}
