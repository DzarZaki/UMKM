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

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Klien</th>
            <th>Email</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservasi as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_klien }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>
                <span class="badge bg-secondary">
                    {{ ucfirst($item->status_reservasi) }}
                </span>
            </td>
            <td>
                <a href="{{ route('reservasi.edit', $item->id) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>

                <form action="{{ route('reservasi.destroy', $item->id) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus data?')"
                            class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

        @if($reservasi->isEmpty())
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada data reservasi
            </td>
        </tr>
        @endif
    </tbody>
</table>
@endsection
