@extends('layouts.app')

@section('title', 'Lamaran Portfolio')

@section('content')
<section class="portfolio-hero">
    <div class="container text-center">
        <h1 class="display-4">Lamaran</h1>
        <p class="text-muted">Capturing love before the big day</p>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        @foreach($galeri as $item)
            <div class="col-md-4">
                <div class="portfolio-item">
                    <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}"
                         alt="{{ $item->judul }}"
                         class="img-fluid">
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
