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

        $file = $request->file('file_galeri');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/galeri'), $namaFile);

        Galeri::create([
            'judul' => $request->judul,
            'file_galeri' => $namaFile,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Data berhasil ditambah!');
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

        if ($request->hasFile('file_galeri')) {
            $pathLama = public_path('galeri/' . $galeri->file_galeri);
            if (File::exists($pathLama)) { File::delete($pathLama); }

            $file = $request->file('file_galeri');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/galeri'), $namaFile);
            $galeri->file_galeri = $namaFile;
        }

        $galeri->judul = $request->judul;
        $galeri->save();
        return redirect()->route('galeri.index')->with('success', 'Data diperbarui!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $path = public_path('galeri/' . $galeri->file_galeri);
        if (File::exists($path)) { File::delete($path); }
        $galeri->delete();
        return redirect()->route('galeri.index')->with('success', 'Data dihapus!');
    }

    public function tampilanHome()
    {
        $galeri = Galeri::latest()->get(); 
        return view('home', compact('galeri'));
    }
}