<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dzar Project')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/home.css') }}" rel="stylesheet"> 
</head>
<body>

    @include('partials.navbar') 

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script>
document.getElementById('waForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const message = document.getElementById('message').value;
    const phone = '6282118111540'; // format internasional (tanpa 0) //GANTI NOMOR WHATSAPP DISINI
    const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;

    window.open(url, '_blank');
});
</script>
    
    @stack('scripts')

</body>
</html>