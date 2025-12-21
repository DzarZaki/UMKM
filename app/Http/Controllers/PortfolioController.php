<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class PortfolioController extends Controller
{
    public function prewedding()
{
    $galeri = Galeri::where('kategori','prewedding')
                    ->latest()
                    ->take(15)
                    ->get();

    return view('portfolio.prewedding', compact('galeri'));
}

public function wedding()
{
    $galeri = Galeri::where('kategori','wedding')
                    ->latest()
                    ->take(15)
                    ->get();

    return view('portfolio.wedding', compact('galeri'));
}

public function wisuda()
{
    $galeri = Galeri::where('kategori','wisuda')
                    ->latest()
                    ->take(15)
                    ->get();

    return view('portfolio.wisuda', compact('galeri'));
}

public function lamaran()
{
    $galeri = Galeri::where('kategori','lamaran')
                    ->latest()
                    ->take(15)
                    ->get();

    return view('portfolio.lamaran', compact('galeri'));
}

}
