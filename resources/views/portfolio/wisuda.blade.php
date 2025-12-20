@extends('layouts.app')

@section('title', 'Portfolio Wisuda')

@section('content')
<section class="gallery-modern">
    <div class="container">
        <h2 class="section-title">Portfolio Wisuda</h2>

        <div class="gallery-grid">
            @forelse($galeri as $item)
                <div class="gallery-item">
                    <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}">
                </div>
            @empty
                <p class="text-center text-muted">Belum ada foto wisuda</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
