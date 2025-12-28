<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dzar Project')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1/main.min.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1/index.global.min.js"></script>

    <!-- Font Awesome (WAJIB untuk IG & TikTok) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- SOCIAL FLOAT (HARUS DI BODY, BUKAN SCRIPT) --}}
    <div class="social-float">
        <a href="https://www.instagram.com/dzargrad?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
           target="_blank"
           class="social-btn instagram"
           aria-label="Instagram">
            <i class="fab fa-instagram"></i>
        </a>

        <a href="https://www.tiktok.com/@dzarlathuf?is_from_webapp=1&sender_device=pc"
           target="_blank"
           class="social-btn tiktok"
           aria-label="TikTok">
            <i class="fab fa-tiktok"></i>
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/home.js') }}"></cript>

    <!-- WhatsApp Form Script -->
    <script>
document.addEventListener('DOMContentLoaded', function () {

    const waBtn = document.getElementById('btnWaSend');
    if (!waBtn) return;

    waBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const phone = '6282118111540'; // nomor WA tujuan (tanpa +)
        const text  = 'Halo, saya ingin bertanya mengenai layanan fotografi.';

        const url = `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
        window.open(url, '_blank');
    });

});
</script>


    @stack('scripts')

</body>
</html>
