@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Reservasi</h1>

{{-- Tombol Tambah Reservasi --}}
<a href="{{ route('reservasi.create') }}"
   class="btn btn-primary mb-3">
    + Tambah Reservasi
</a>

{{-- Pesan sukses --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="bg-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Tipe Paket</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>

            <tbody>
@forelse($reservasi as $item)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->nama }}</td>

    <td>{{ $item->email }}</td>

    <td>{{ $item->no_hp }}</td>

    <td>{{ $item->tipe_paket ?? '-' }}</td>

    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>

    {{-- WAKTU --}}
    <td>
        <small class="text-muted">
            {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
        </small>
    </td>

    {{-- STATUS --}}
    <td>
        @php
            $badge = match($item->status) {
                'pending' => 'secondary',
                'in_progress' => 'warning',
                'done' => 'success',
                default => 'secondary'
            };
        @endphp

        <span class="badge bg-light text-dark border">
            {{ str_replace('_', ' ', ucfirst($item->status)) }}
        </span>

    </td>

    {{-- AKSI --}}
    <td>
        <a href="{{ route('reservasi.edit', $item->id) }}"
           class="btn btn-sm btn-warning mb-1">
            Edit
        </a>

        <form action="{{ route('reservasi.destroy', $item->id) }}"
              method="POST"
              class="d-inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Hapus data reservasi?')"
                    class="btn btn-sm btn-danger">
                Hapus
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center text-muted">
        Belum ada data reservasi
    </td>
</tr>
@endforelse
</tbody>

        </table>

    </div>
</div>
@endsection
