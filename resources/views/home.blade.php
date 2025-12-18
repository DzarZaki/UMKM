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

    {{-- GALLERY SECTION (Dinamis dari Database) --}}
    <section class="gallery-modern" id="gallery">
        <div class="container">
            <div class="section-header">
                <p class="section-label">OUR PORTFOLIO</p>
                <h2 class="section-title">Recent Works</h2>
            </div>
            
            <div class="gallery-grid">
                {{-- 
                    LOOPING DATA GALERI:
                    Laravel akan mengulang bagian ini sebanyak data yang ada di tabel 'galeri'
                --}}
                @forelse($galeri as $item)
                    <div class="gallery-item">
                        <img src="{{ asset('galeri/' . $item->file_galeri) }}" alt="{{ $item->judul }}">
                        <div class="gallery-overlay">
                            <span class="gallery-caption">{{ $item->judul }}</span>
                        </div>
                    </div>
                @empty
                    {{-- Pesan jika database masih kosong --}}
                    <div class="col-12 text-center text-muted">
                        <p>Belum ada karya yang diunggah ke galeri.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection