@extends('admin.dashboard')

@section('content')

<div class="container mt-4">

    <h2>Edit Galeri</h2>

    <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-top:15px;">
            <label>Judul</label><br>
            <input type="text" name="judul" value="{{ $galeri->judul }}" required>
            @error('judul')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top:15px;">
            <label>Gambar Lama</label><br>
            <img src="{{ asset('galeri/' . $galeri->file_galeri) }}" width="150" style="margin-top:5px;">
        </div>

        <div style="margin-top:15px;">
            <label>Ganti Gambar (opsional)</label><br>
            <input type="file" name="file_galeri" accept="image/*">
            @error('file_galeri')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <button style="margin-top:20px; padding:8px 20px; background:#4CAF50; color:white; border:none;">
            Update
        </button>

    </form>

</div>

@endsection
