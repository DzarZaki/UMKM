@extends('layouts.dashboard')

@section('content')
<h1 class="h3 mb-4">Edit Fotografer</h1>

<form method="POST" action="{{ route('fotografer.update', $fotografer->id) }}">
@csrf
@method('PUT')

<div class="form-group">
  <label>Nama Fotografer</label>
  <input type="text" name="nama_fotografer"
         class="form-control"
         value="{{ $fotografer->nama_fotografer }}"
         required>
</div>

<div class="form-group">
  <label>Spesialisasi</label>
  <input type="text" name="spesialisasi"
         class="form-control"
         value="{{ $fotografer->spesialisasi }}">
</div>

<button class="btn btn-primary">Update</button>
<a href="{{ route('fotografer.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
