@extends('layouts.dashboard')

@section('title', 'Galeri')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Galeri</h1>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('galeri.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Galeri
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galeri as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}" width="120">
                            </td>
                            <td>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('galeri.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('galeri.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data galeri
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
