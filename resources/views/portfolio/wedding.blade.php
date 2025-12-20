@extends('layouts.app')

@section('title', 'Wedding Portfolio')

@section('content')
<section class="container py-5">
    <h1 class="text-center mb-5">Wedding</h1>

    <div class="row g-4">
        @foreach($galeri as $item)
            <div class="col-md-4">
                <div class="portfolio-item">
                    <img src="{{ asset("uploads/galeri/{$item->file_galeri}") }}"
                         alt="{{ $item->judul }}"
                         class="img-fluid">
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
