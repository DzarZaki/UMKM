@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4">Fotografer</h1>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<button class="btn btn-success mb-3" data-toggle="modal" data-target="#createModal">
  + Tambah Fotografer
</button>

<div class="card shadow">
  <div class="card-body p-0">
    <table class="table table-bordered mb-0">
      <thead class="bg-light">
        <tr>
          <th>Nama (Username)</th>
          <th>Role</th>
          <th width="180">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($fotografer as $f)
        <tr>
          <td>{{ $f->username }}</td>
          <td>{{ ucfirst(str_replace('_',' ', $f->role)) }}</td>
          <td>
            <!-- EDIT -->
            <button class="btn btn-sm btn-warning"
              data-toggle="modal"
              data-target="#editModal{{ $f->id }}">
              Edit
            </button>

            <!-- HAPUS -->
            <form action="{{ route('fotografer.destroy',$f->id) }}"
                  method="POST"
                  class="d-inline">
              @csrf
              @method('DELETE')
              <button onclick="return confirm('Hapus fotografer?')"
                      class="btn btn-sm btn-danger">
                Hapus
              </button>
            </form>
          </td>
        </tr>

        {{-- MODAL EDIT --}}
        <div class="modal fade" id="editModal{{ $f->id }}">
          <div class="modal-dialog">
            <form method="POST"
                  action="{{ route('fotografer.update',$f->id) }}"
                  class="modal-content">
              @csrf
              @method('PUT')

              <div class="modal-header">
                <h5>Edit Fotografer</h5>
                <button class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                <div class="form-group">
                  <label>Nama (Username)</label>
                  <input name="username"
                         class="form-control"
                         value="{{ $f->username }}"
                         required>
                </div>

                <div class="form-group">
                  <label>Role</label>
                  <select name="role" class="form-control">
                    <option value="fotografer" {{ $f->role=='fotografer'?'selected':'' }}>Fotografer</option>
                    <option value="videografer" {{ $f->role=='videografer'?'selected':'' }}>Videografer</option>
                    <option value="fotografer_videografer" {{ $f->role=='fotografer_videografer'?'selected':'' }}>
                      Fotografer & Videografer
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Password (opsional)</label>
                  <input type="password" name="password" class="form-control">
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="3" class="text-center text-muted">
            Belum ada fotografer
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal">
  <div class="modal-dialog">
    <form method="POST"
          action="{{ route('fotografer.store') }}"
          class="modal-content">
      @csrf

      <div class="modal-header">
        <h5>Tambah Fotografer</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>Nama (Username)</label>
          <input name="username" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control">
            <option value="fotografer">Fotografer</option>
            <option value="videografer">Videografer</option>
            <option value="fotografer_videografer">Fotografer & Videografer</option>
          </select>
        </div>

        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
