@extends('layouts.dashboard')

@section('content')

<div class="container mt-4">

    <h2>Tambah Galeri</h2>

    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-top:15px;">
            <label>Judul</label><br>
            <input type="text" name="judul" value="{{ old('judul') }}" required>
            @error('judul')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="prewedding">Prewedding</option>
                <option value="wedding">Wedding</option>
                <option value="wisuda">Wisuda</option>
                <option value="lamaran">Lamaran</option>
            </select>
        </div>

        <div style="margin-top:15px;">
            <label>Upload Gambar</label><br>
            <input type="file" name="file_galeri" accept="image/*" required>
            @error('file_galeri')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <button style="margin-top:20px; padding:8px 20px; background:#4CAF50; color:white; border:none;">
            Simpan
        </button>

    </form>

</div>

@endsection
