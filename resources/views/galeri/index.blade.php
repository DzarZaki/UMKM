@extends('admin.dashboard')

@section('content')

<div class="container mt-4">

    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <h2>Daftar Galeri</h2>

    {{-- Hanya admin boleh upload --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('galeri.create') }}" 
           style="padding:10px; background:#4CAF50; color:white; text-decoration:none; border-radius:5px;">
            + Tambah Galeri
        </a>
    @endif

    <table border="1" width="100%" cellpadding="10" style="margin-top:20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($galeri as $g)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $g->judul }}</td>
                <td>
                    <img src="{{ asset('galeri/' . $g->file_galeri) }}" width="120">
                </td>
                <td>
                    {{-- Hanya admin boleh edit/delete --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('galeri.edit', $g->id) }}">Edit</a> |
                        <form 
                            action="{{ route('galeri.destroy', $g->id) }}" 
                            method="POST" 
                            style="display:inline"
                            onsubmit="return confirm('Yakin ingin menghapus?')">
                            
                            @csrf
                            @method('DELETE')
                            <button style="color:red; background:none; border:none; cursor:pointer;">
                                Hapus
                            </button>

                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
