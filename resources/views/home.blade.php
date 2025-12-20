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

    {{-- RECENT WORKS TITLE --}}
<section class="recent-works-title">
    <div class="container">
        <p class="section-label">OUR PORTFOLIO</p>
        <h2 class="section-heading">Recent Works</h2>
    </div>
</section>


    {{-- GALLERY SECTION (Dinamis dari Database) --}}
   <section class="home-gallery">
    <div class="gallery-container">
        <div class="gallery-grid">


    {{-- PREWEDDING --}}
    @if($prewedding)
        <div class="gallery-item">
            <img src="{{ asset('uploads/galeri/'.$prewedding->file_galeri) }}">
            <div class="gallery-overlay">
                <span>Prewedding</span>
            </div>
        </div>
    @else
        <p class="text-muted">Belum ada Prewedding</p>
    @endif

    {{-- WEDDING --}}
    @if($wedding)
        <div class="gallery-item">
            <img src="{{ asset('uploads/galeri/'.$wedding->file_galeri) }}">
            <div class="gallery-overlay">
                <span>Wedding</span>
            </div>
        </div>
    @else
        <p class="text-muted">Belum ada Wedding</p>
    @endif

    {{-- WISUDA --}}
    @if($wisuda)
        <div class="gallery-item">
            <img src="{{ asset('uploads/galeri/'.$wisuda->file_galeri) }}">
            <div class="gallery-overlay">
                <span>Wisuda</span>
            </div>
        </div>
    @else
        <p class="text-muted">Belum ada Wisuda</p>
    @endif

    {{-- LAMARAN --}}
    @if($lamaran)
        <div class="gallery-item">
            <img src="{{ asset('uploads/galeri/'.$lamaran->file_galeri) }}">
            <div class="gallery-overlay">
                <span>Lamaran</span>
            </div>
        </div>
    @else
        <p class="text-muted">Belum ada Lamaran</p>
    @endif

</div>
