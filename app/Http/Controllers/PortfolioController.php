<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class PortfolioController extends Controller
{
    public function prewedding()
    {
        // sementara ambil semua dulu
        // nanti bisa difilter kategori
        $galeri = Galeri::latest()->get();

        return view('portfolio.prewedding', compact('galeri'));
    }

    public function wedding()
    {
        $galeri = Galeri::latest()->get();

        return view('portfolio.wedding', compact('galeri'));
    }
}
