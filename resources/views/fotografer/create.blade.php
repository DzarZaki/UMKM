@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4">Tambah Fotografer</h1>

<form method="POST" action="{{ route('fotografer.store') }}">
@csrf

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
  <input type="text" name="nama_fotografer" class="form-control" required>
</div>

<div class="form-group">
  <label>Spesialisasi</label>
  <input type="text" name="spesialisasi" class="form-control">
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('fotografer.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
