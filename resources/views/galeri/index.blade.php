@extends('layouts.dashboard')

@section('title', 'Galeri')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Manajemen Galeri</h1>

@foreach(['prewedding','wedding','wisuda','lamaran'] as $kategori)

@php
    $items = $galeri->where('kategori', $kategori);
    $count = $items->count();
@endphp

<div class="card shadow mb-4">

    {{-- CARD HEADER --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0 font-weight-bold text-primary text-capitalize">
                {{ $kategori }}
            </h6>
            <small class="text-muted">{{ $count }} / 7 foto</small>
        </div>

        @if($count < 7)
            <button class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#modalTambah"
                    data-kategori="{{ $kategori }}">
                + Tambah Galeri
            </button>
        @endif
    </div>

    {{-- CARD BODY --}}
    <div class="card-body">
        @if($count === 0)
            <p class="text-muted mb-0">Belum ada foto.</p>
        @else
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-3 mb-4">

                        {{-- ITEM --}}
                        <div class="gallery-admin-item position-relative">
                            <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}"
                                 class="img-fluid rounded">

                            {{-- OVERLAY --}}
                            <div class="gallery-admin-overlay text-center">
                                <button class="btn btn-warning btn-sm mb-1"
                                        data-toggle="modal"
                                        data-target="#modalEdit{{ $item->id }}">
                                    Edit
                                </button>

                                <button class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#modalHapus{{ $item->id }}">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <p class="small text-center mt-2 mb-0">
                            {{ $item->judul }}
                        </p>
                    </div>

                    {{-- MODAL EDIT --}}
                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('galeri.update', $item->id) }}"
                                  method="POST"
                                  enctype="multipart/form-data"
                                  class="modal-content">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Galeri</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text"
                                               name="judul"
                                               class="form-control"
                                               value="{{ $item->judul }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control">
                                            @foreach(['prewedding','wedding','wisuda','lamaran'] as $kat)
                                                <option value="{{ $kat }}"
                                                    {{ $item->kategori == $kat ? 'selected' : '' }}>
                                                    {{ ucfirst($kat) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Gambar</label><br>
                                        <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}"
                                             width="100"
                                             class="mb-2">
                                        <input type="file"
                                               name="file_galeri"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL HAPUS --}}
                    <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('galeri.destroy', $item->id) }}"
                                  method="POST"
                                  class="modal-content text-center">
                                @csrf
                                @method('DELETE')

                                <div class="modal-body">
                                    <h5>Yakin mau menghapus?</h5>
                                </div>

                                <div class="modal-footer justify-content-center">
                                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>
</div>

@endforeach

{{-- MODAL TAMBAH (HANYA 1x) --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('galeri.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Galeri</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="prewedding">Prewedding</option>
                        <option value="wedding">Wedding</option>
                        <option value="wisuda">Wisuda</option>
                        <option value="lamaran">Lamaran</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="file_galeri" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>

@endsection
