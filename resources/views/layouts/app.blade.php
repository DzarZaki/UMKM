<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dzar Project')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar (jika dipakai di halaman tertentu) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1/index.global.min.js"></script>

    <!-- Font Awesome -->
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

    {{-- SOCIAL FLOAT --}}
    <div class="social-float">
        <a href="https://www.instagram.com/dzargrad"
           target="_blank"
           class="social-btn instagram"
           aria-label="Instagram">
            <i class="fab fa-instagram"></i>
        </a>

        <a href="https://www.tiktok.com/@dzarlathuf"
           target="_blank"
           class="social-btn tiktok"
           aria-label="TikTok">
            <i class="fab fa-tiktok"></i>
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS (FIX TYPO) -->
    <script src="{{ asset('js/home.js') }}"></script>

    <!-- WhatsApp Send Message Script (FINAL & AMAN) -->
   <script>
document.addEventListener('DOMContentLoaded', function () {

    const btnWa = document.getElementById('btnWaSend');
    if (!btnWa) return;

    btnWa.addEventListener('click', function () {

        const phone = '6282118111540'; // TANPA +
        const messageEl = document.getElementById('waMessage');
        const text = messageEl && messageEl.value
            ? messageEl.value
            : 'Halo, saya ingin bertanya mengenai layanan fotografi.';

        const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(text);
        window.open(waUrl, '_blank');
    });

});
</script>

    @stack('scripts')

</body>
</html>
