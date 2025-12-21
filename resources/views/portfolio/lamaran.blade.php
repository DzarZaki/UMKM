@extends('layouts.app')

@section('title', 'Portfolio Lamaran')

@section('content')
<div class="container mt-5">
    <h1 class="text-white mb-4">Portfolio Lamaran</h1>

    <div class="portfolio-grid">
        @forelse($galeri as $item)
            <div class="portfolio-card">
                <div class="portfolio-image">
                    <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}"
                         alt="{{ $item->judul }}">
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada foto lamaran.</p>
        @endforelse
    </div>
</div>
@endsection
