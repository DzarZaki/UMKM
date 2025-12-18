@extends('layouts.app')

@section('title', 'Dzar Project | Modern Photography')

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-modern" id="hero"> 
        <div class="hero-video-container">
            {{-- Karena Anda bilang tidak ada video, saya siapkan fallback ke gambar jika file mp4 tidak ada --}}
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
    <section class="featured-section" id="featured" style="background-image: url('{{ asset('src/hero2.jpg') }}');">
        <div class="featured-overlay"></div>
        <div class="container">
            <div class="featured-content">
                <p class="featured-label">FEATURED WORK</p>
                <h2 class="featured-title">Hardi & Jesslyn<br>Wedding Day</h2>
                <p class="featured-desc">
                    An intimate celebration of love captured in the breathtaking landscapes of Bali. 
                    Every moment tells a story of elegance and emotion.
                </p>
                <a href="#" class="btn-explore">
                    VIEW FULL STORY
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
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

    {{-- GALLERY SECTION --}}
    <section class="gallery-modern" id="gallery">
        <div class="container">
            <div class="section-header">
                <p class="section-label">OUR PORTFOLIO</p>
                <h2 class="section-title">Recent Works</h2>
            </div>
            
            <div class="gallery-grid">
                {{-- Menggunakan file-file yang ada di folder src Anda --}}
                <div class="gallery-item">
                    <img src="{{ asset('src/satu.png') }}" alt="Gallery 1">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('src/dua.png') }}" alt="Gallery 2">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('src/tiga.png') }}" alt="Gallery 3">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('src/empat.png') }}" alt="Gallery 4">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('src/g1.png') }}" alt="Gallery 5">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('src/g2.png') }}" alt="Gallery 6">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('src/g3.png') }}" alt="Gallery 7">
                </div>
            </div>
        </div>
    </section>

@endsection