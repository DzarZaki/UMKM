@extends('layouts.app')

@section('title', 'Dzar Project | Modern Photography')

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-modern" id="hero"> 
        <div class="hero-video-container">
            <video autoplay muted loop playsinline>
                <source src="{{ asset('src/hero-video.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="hero-overlay">
            <div class="hero-content">
                <h1 class="hero-title">DZAR</h1>
                <p class="hero-subtitle">CAPTURING TIMELESS MOMENTS</p>
            </div>
        </div>
        <div class="scroll-indicator">
            <span></span>
        </div>
    </section>

    {{-- FEATURED SECTION --}}
    <section class="featured-section" id="featured"
    style="
        background-image: 
        @if($featured)
            url('{{ asset('uploads/galeri/'.$featured->file_galeri) }}')
        @else
            url('{{ asset('src/hero2.jpg') }}')
        @endif
    ;">

        <div class="featured-overlay"></div>
    </section>

    {{-- STATS SECTION --}}
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">MOMENTS CAPTURED</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">HAPPY COUPLES</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">5+</div>
                        <div class="stat-label">YEARS EXPERIENCE</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RECENT WORKS TITLE --}}
<section class="recent-works-title text-center">
    <div class="container">
        <p class="section-label">OUR PORTFOLIO</p>
        <h2 class="section-heading">Recent Works</h2>
    </div>
</section>

{{-- HOME GALLERY --}}
<section class="home-gallery">
    <div class="container">
        <div class="row justify-content-center">

            {{-- PREWEDDING --}}
            @if($prewedding)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('portfolio.prewedding') }}" class="home-gallery-link">
                        <div class="home-gallery-card">
                            <img src="{{ asset('uploads/galeri/'.$prewedding->file_galeri) }}"
                                 class="img-fluid">
                        </div>
                        <p class="home-gallery-title">Prewedding</p>
                    </a>
                </div>
            @endif

            {{-- WEDDING --}}
            @if($wedding)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('portfolio.wedding') }}" class="home-gallery-link">
                        <div class="home-gallery-card">
                            <img src="{{ asset('uploads/galeri/'.$wedding->file_galeri) }}"
                                 class="img-fluid">
                        </div>
                        <p class="home-gallery-title">Wedding</p>
                    </a>
                </div>
            @endif

            {{-- WISUDA --}}
            @if($wisuda)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('portfolio.wisuda') }}" class="home-gallery-link">
                        <div class="home-gallery-card">
                            <img src="{{ asset('uploads/galeri/'.$wisuda->file_galeri) }}"
                                 class="img-fluid">
                        </div>
                        <p class="home-gallery-title">Wisuda</p>
                    </a>
                </div>
            @endif

            {{-- LAMARAN --}}
            @if($lamaran)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('portfolio.lamaran') }}" class="home-gallery-link">
                        <div class="home-gallery-card">
                            <img src="{{ asset('uploads/galeri/'.$lamaran->file_galeri) }}"
                                 class="img-fluid">
                        </div>
                        <p class="home-gallery-title">Lamaran</p>
                    </a>
                </div>
            @endif

        </div>
    </div>
</section>
