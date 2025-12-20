<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class HomeController extends Controller
{
        public function index()
    {
        return view('home', [
            'prewedding' => Galeri::where('kategori','prewedding')->latest()->first(),
            'wedding'    => Galeri::where('kategori','wedding')->latest()->first(),
            'wisuda'     => Galeri::where('kategori','wisuda')->latest()->first(),
            'lamaran'    => Galeri::where('kategori','lamaran')->latest()->first(),
        ]);
    }

}