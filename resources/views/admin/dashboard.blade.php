<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    
    <h2>Dashboard</h2>

    <p>Selamat datang, <strong>{{ auth()->user()->username }}</strong></p>
    <p>Role Anda: <strong>{{ auth()->user()->role }}</strong></p>

    {{-- Tombol khusus admin --}}
    @if(auth()->user()->role == 'admin')
        <a href="/reservasi/create" style="padding:10px;background:blue;color:white;border-radius:5px;">
            + Tambah Reservasi
        </a>
    @endif

    {{-- Fotografer hanya readonly --}}
    @if(auth()->user()->role == 'fotografer')
        <!-- <p style="color:green;">Mode READ ONLY (Fotografer tidak bisa tambah data)</p> -->
    @endif


    {{-- Tombol logout --}}
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" style="margin-top:20px;">Logout</button>
    </form>
</body>
</html>