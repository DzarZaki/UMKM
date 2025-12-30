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
        <input type="text"
               name="nama"
               class="form-control"
               value="{{ old('nama') }}"
               required>
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email') }}"
               required>
    </div>

    {{-- Nomor HP --}}
    <div class="mb-3">
        <label class="form-label">Nomor HP</label>
        <input type="text"
               name="no_hp"
               class="form-control"
               value="{{ old('no_hp') }}"
               required>
    </div>

    {{-- Tipe Paket --}}
    <div class="mb-3">
        <label class="form-label">Tipe Paket (Opsional)</label>
        <input type="text"
               name="tipe_paket"
               class="form-control"
               value="{{ old('tipe_paket') }}">
    </div>

    {{-- Tanggal --}}
    <div class="mb-3">
        <label class="form-label">Tanggal Reservasi</label>
        <input type="date"
               name="tanggal"
               class="form-control"
               value="{{ old('tanggal') }}"
               required>
    </div>

    {{-- Waktu --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Waktu Mulai</label>
            <input type="time"
                   name="waktu_mulai"
                   class="form-control"
                   value="{{ old('waktu_mulai') }}"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Waktu Selesai</label>
            <input type="time"
                   name="waktu_selesai"
                   class="form-control"
                   value="{{ old('waktu_selesai') }}"
                   required>
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="mb-3">
        <label class="form-label">Keterangan (Opsional)</label>
        <textarea name="keterangan"
                  class="form-control"
                  rows="3">{{ old('keterangan') }}</textarea>
    </div>

    {{-- Fotografer --}}
<div class="mb-3">
    <label class="form-label">Fotografer / Videografer</label>
    <select name="user_id" class="form-control">
        <option value="">-- Pilih Fotografer / Videografer --</option>
        @foreach ($usersFotografer as $u)
            <option value="{{ $u->id }}"
                {{ old('user_id') == $u->id ? 'selected' : '' }}>
                {{ $u->username }} - {{ ucfirst(str_replace('_',' ', $u->role)) }}
            </option>
        @endforeach
    </select>
</div>


    <!-- {{-- Kalender --}}
    <div class="mb-3">
        <label class="form-label">Kalender</label>
        <select name="id_kalender" class="form-control">
            <option value="">-- Pilih Kalender --</option>
            @foreach ($kalender as $k)
                <option value="{{ $k->id }}"
                    {{ old('id_kalender') == $k->id ? 'selected' : '' }}>
                    {{ $k->tanggal }} ({{ $k->waktu_mulai }} - {{ $k->waktu_selesai }})
                </option>
            @endforeach
        </select>
    </div> -->

    {{-- Status --}}
    <div class="mb-3">
        <label class="form-label">Status Reservasi</label>
        <select name="status" class="form-control">
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
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

<script>
document.querySelector('form').addEventListener('submit', function (e) {
    const email = document.querySelector('input[name="email"]').value.trim();
    const noHp = document.querySelector('input[name="no_hp"]').value.trim();
    const fotografer = document.querySelector('select[name="user_id"]').value;


    // Validasi Email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        alert('Email wajib diisi');
        e.preventDefault();
        return;
    }
    if (!emailRegex.test(email)) {
        alert('Format email tidak valid');
        e.preventDefault();
        return;
    }

    // Validasi No HP
    const hpRegex = /^[0-9]{10,15}$/;
    if (!noHp) {
        alert('Nomor HP wajib diisi');
        e.preventDefault();
        return;
    }
    if (!hpRegex.test(noHp)) {
        alert('Nomor HP harus berupa angka (10–15 digit)');
        e.preventDefault();
        return;
    }

});
</script>

