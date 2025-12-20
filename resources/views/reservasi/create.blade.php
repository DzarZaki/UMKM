@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Reservasi</h1>

{{-- Tampilkan error validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reservasi.store') }}" method="POST">
    @csrf

    {{-- Nama Klien --}}
    <div class="mb-3">
        <label class="form-label">Nama Klien</label>
        <input
            type="text"
            name="nama_klien"
            class="form-control"
            value="{{ old('nama_klien') }}"
            required
        >
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email') }}"
            required
        >
    </div>

    {{-- Tanggal Reservasi --}}
    <div class="mb-3">
        <label class="form-label">Tanggal Reservasi</label>
        <input
            type="date"
            name="tanggal"
            class="form-control"
            value="{{ old('tanggal') }}"
            required
        >
    </div>

    {{-- Fotografer (dari tabel users role=fotografer) --}}
    <div class="mb-3">
        <label class="form-label">Fotografer</label>
                <select name="id_fotografer" class="form-control" required>
            <option value="">-- Pilih Fotografer / Videografer --</option>
            @foreach ($fotografer as $f)
                <option value="{{ $f->id }}">
                    {{ $f->username }} 
                </option>
            @endforeach
        </select>
    </div>

    {{-- Kalender --}}
    <div class="mb-3">
        <label class="form-label">Kalender</label>
        <select name="id_kalender" class="form-control" required>
            <option value="">-- Pilih Kalender --</option>
            @foreach ($kalender as $k)
                <option
                    value="{{ $k->id }}"
                    {{ old('id_kalender') == $k->id ? 'selected' : '' }}
                >
                    {{ $k->tanggal }} ({{ $k->waktu_mulai }} - {{ $k->waktu_selesai }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Status Reservasi --}}
    <div class="mb-3">
        <label class="form-label">Status Reservasi</label>
        <select name="status_reservasi" class="form-control">
            <option value="pending" {{ old('status_reservasi') == 'pending' ? 'selected' : '' }}>
                Pending
            </option>
            <option value="confirmed" {{ old('status_reservasi') == 'confirmed' ? 'selected' : '' }}>
                Confirmed
            </option>
            <option value="cancelled" {{ old('status_reservasi') == 'cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>
        </select>
    </div>

    {{-- Tombol --}}
    <button type="submit" class="btn btn-primary">
        Simpan
    </button>
    <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">
        Batal
    </a>
</form>
@endsection
