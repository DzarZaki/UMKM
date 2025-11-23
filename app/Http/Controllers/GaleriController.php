<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GaleriController extends Controller
{
   

    public function index()
    {
        $galeri = Galeri::latest()->get();
        return view('galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'file_galeri' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload file
        $file = $request->file('file_galeri');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('galeri'), $namaFile);

        Galeri::create([
            'judul' => $request->judul,
            'file_galeri' => $namaFile,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'file_galeri' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Kalau upload gambar baru
        if ($request->hasFile('file_galeri')) {

            // Hapus file lama
            $pathLama = public_path('galeri/' . $galeri->file_galeri);
            if (File::exists($pathLama)) {
                File::delete($pathLama);
            }

            // Upload file baru
            $file = $request->file('file_galeri');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('galeri'), $namaFile);

            $galeri->file_galeri = $namaFile;
        }

        $galeri->judul = $request->judul;
        $galeri->save();

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus file fisik
        $path = public_path('galeri/' . $galeri->file_galeri);
        if (File::exists($path)) {
            File::delete($path);
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil dihapus!');
    }
}
