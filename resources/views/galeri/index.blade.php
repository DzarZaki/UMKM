@extends('layouts.dashboard')

@section('title', 'Galeri')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Manajemen Galeri</h1>

@php
$kategoris = ['featured','prewedding','wedding','wisuda','lamaran'];
@endphp

@foreach($kategoris as $kategori)

@php
    $items = $galeri->where('kategori', $kategori);
    $max   = $kategori === 'featured' ? 1 : 15;
@endphp

<div class="card shadow mb-4">

    {{-- HEADER --}}
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0 font-weight-bold text-primary text-capitalize">
                {{ $kategori === 'featured'
                    ? 'Featured Background (Home)'
                    : ucfirst($kategori)
                }}
            </h6>
            <small class="text-muted">
                {{ $items->count() }} / {{ $max }} foto
            </small>
        </div>

        @if($items->count() < $max)
            <button class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#modalTambah-{{ $kategori }}">
                + Tambah Galeri
            </button>
        @endif
    </div>

    {{-- BODY --}}
    <div class="card-body">
        @if($items->isEmpty())
            <p class="text-muted mb-0">Belum ada data.</p>
        @else
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-3 mb-4 text-center">

                        <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}"
                             class="img-fluid rounded mb-2"
                             style="max-height:180px; object-fit:cover;">

                        <p class="small mb-2">{{ $item->judul }}</p>

                        <button class="btn btn-warning btn-sm"
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
                                    <input type="hidden" name="kategori" value="{{ $item->kategori }}">

                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text"
                                               name="judul"
                                               class="form-control"
                                               value="{{ $item->judul }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Gambar Lama</label><br>
                                        <img src="{{ asset('uploads/galeri/'.$item->file_galeri) }}"
                                             width="120"
                                             class="mb-2 rounded">
                                    </div>

                                    <div class="form-group">
                                        <label>Ganti Gambar (opsional)</label>
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


{{-- =======================
     MODAL TAMBAH (PER KATEGORI)
======================= --}}
@foreach($kategoris as $kategori)

<div class="modal fade" id="modalTambah-{{ $kategori }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('galeri.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">
                    Tambah Galeri {{ ucfirst($kategori) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="kategori" value="{{ $kategori }}">

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text"
                           name="judul"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file"
                           name="file_galeri"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

@endforeach

@endsection
