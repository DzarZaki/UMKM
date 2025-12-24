@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Fotografer</h1>

<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
  + Tambah Fotografer
</button>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead class="bg-light">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>User</th>
          <th>Role</th>
          <th>Spesialisasi</th>
          <th>Reservasi</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($fotografer as $f)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $f->nama_fotografer }}</td>
          <td>{{ $f->user->username ?? '-' }}</td>
          <td>{{ $f->user->role ?? '-' }}</td>
          <td>{{ $f->spesialisasi ?? '-' }}</td>
          <td>{{ $f->reservasi_count }}</td>
          <td>
            <button class="btn btn-sm btn-warning"
              data-toggle="modal"
              data-target="#modalEdit{{ $f->id }}">
              Edit
            </button>

            <form action="{{ route('fotografer.destroy', $f->id) }}"
                  method="POST"
                  class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger"
                      onclick="return confirm('Hapus fotografer?')">
                Hapus
              </button>
            </form>
          </td>
        </tr>

        {{-- MODAL EDIT --}}
        <div class="modal fade" id="modalEdit{{ $f->id }}">
          <div class="modal-dialog">
            <form method="POST"
                  action="{{ route('fotografer.update', $f->id) }}"
                  class="modal-content">
              @csrf
              @method('PUT')

              <div class="modal-header">
                <h5 class="modal-title">Edit Fotografer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                <div class="form-group">
                  <label>Nama Fotografer</label>
                  <input type="text"
                         name="nama_fotografer"
                         class="form-control"
                         value="{{ $f->nama_fotografer }}"
                         required>
                </div>

                <div class="form-group">
                  <label>Spesialisasi</label>
                  <input type="text"
                         name="spesialisasi"
                         class="form-control"
                         value="{{ $f->spesialisasi }}">
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-success">Simpan</button>
              </div>
            </form>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="7" class="text-center text-muted">
            Belum ada fotografer
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <form method="POST"
          action="{{ route('fotografer.store') }}"
          class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Tambah Fotografer</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>User</label>
          <select name="user_id" class="form-control" required>
            <option value="">-- pilih user --</option>
            @foreach($users as $u)
              <option value="{{ $u->id }}">
                {{ $u->username }} ({{ $u->role }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Nama Fotografer</label>
          <input type="text"
                 name="nama_fotografer"
                 class="form-control"
                 required>
        </div>

        <div class="form-group">
          <label>Spesialisasi</label>
          <input type="text"
                 name="spesialisasi"
                 class="form-control">
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
