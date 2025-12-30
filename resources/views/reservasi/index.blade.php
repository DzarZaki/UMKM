@extends('layouts.dashboard')

@section('content')
<style>
  .reservasi-table-wrap{
    max-height: calc(100vh - 350px);
    overflow-y: auto;
    overflow-x: auto;
  }
  .reservasi-table-wrap thead th{
    position: sticky;
    top: 0;
    z-index: 3;
    background: #f8f9fc;
  }
  .reservasi-table-wrap table{
    border-collapse: separate;
    border-spacing: 0;
  }
</style>

<h1 class="h3 mb-4 text-gray-800">Reservasi</h1>

{{-- FILTER --}}
<form method="GET" class="mb-3">
  <div class="form-row">
    <div class="col-md-3 mb-2">
      <select name="status" class="form-control">
        <option value="">-- Semua Status --</option>
        @foreach(['new','pending','in_progress','done'] as $st)
          <option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>
            {{ ucfirst(str_replace('_',' ', $st)) }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-4 mb-2">
      <input type="text" name="q" class="form-control"
             placeholder="Cari nama / email / no hp"
             value="{{ request('q') }}">
    </div>

    <div class="col-md-2 mb-2">
      <button class="btn btn-primary btn-block">Filter</button>
    </div>
  </div>

  @if(request()->hasAny(['status','q']))
    <a href="{{ route('reservasi.index') }}" class="btn btn-link p-0">Reset</a>
  @endif
</form>

<button type="button" class="btn btn-success mb-3" id="btnTambah">
  + Tambah Reservasi
</button>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
  <div class="card-body p-0">
    <div class="reservasi-table-wrap">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Fotografer</th>
            <th>Paket</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
            <th width="150">Aksi</th>
          </tr>
        </thead>
        <tbody>

@forelse ($reservasi as $item)
@php
  $badge = match($item->status) {
    'new' => 'secondary',
    'pending' => 'warning',
    'in_progress' => 'info',
    'done' => 'success',
  };
@endphp

<tr
  data-id="{{ $item->id }}"
  data-nama="{{ e($item->nama) }}"
  data-email="{{ e($item->email) }}"
  data-no_hp="{{ e($item->no_hp) }}"
  data-tipe_paket="{{ e($item->tipe_paket ?? '') }}"
  data-tanggal="{{ $item->tanggal }}"
  data-waktu_mulai="{{ substr($item->waktu_mulai,0,5) }}"
  data-waktu_selesai="{{ substr($item->waktu_selesai,0,5) }}"
  data-keterangan="{{ e($item->keterangan ?? '') }}"
  data-status="{{ $item->status }}"
  data-user_id="{{ $item->user_id ?? '' }}"
>
  <td>{{ ($reservasi->currentPage()-1)*$reservasi->perPage() + $loop->iteration }}</td>
  <td>{{ $item->nama }}</td>
  <td>{{ $item->email }}</td>
  <td>{{ $item->no_hp }}</td>

  <td>
    {{ $item->user
      ? $item->user->username.' - '.ucfirst(str_replace('_',' ', $item->user->role))
      : '-' }}
  </td>

  <td>{{ $item->tipe_paket ?? '-' }}</td>
  <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
  <td>{{ substr($item->waktu_mulai,0,5) }} - {{ substr($item->waktu_selesai,0,5) }}</td>
  <td><span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_',' ', $item->status)) }}</span></td>
  <td>
    <button class="btn btn-sm btn-warning btnEdit">Edit</button>
    <button class="btn btn-sm btn-danger btnHapus">Hapus</button>
  </td>
</tr>
@empty
<tr>
  <td colspan="10" class="text-center text-muted">Belum ada data</td>
</tr>
@endforelse

        </tbody>
      </table>
    </div>
  </div>
</div>

{{ $reservasi->links('pagination::bootstrap-4') }}

{{-- MODAL --}}
<div class="modal fade" id="reservasiModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reservasi</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

<input type="hidden" id="id_reservasi">

<div class="row">
  <div class="col-md-6">
    <input id="nama" class="form-control mb-2" placeholder="Nama">
    <input id="email" class="form-control mb-2" placeholder="Email">
    <input id="no_hp" class="form-control mb-2" placeholder="No HP">
    <input id="tipe_paket" class="form-control mb-2" placeholder="Paket">
    <textarea id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
  </div>

  <div class="col-md-6">
    <input type="date" id="tanggal" class="form-control mb-2">
    <select id="status" class="form-control mb-2">
      <option value="new">New</option>
      <option value="pending">Pending</option>
      <option value="in_progress">In Progress</option>
      <option value="done">Done</option>
    </select>

    <input type="time" id="waktu_mulai" class="form-control mb-2">
    <input type="time" id="waktu_selesai" class="form-control mb-2">

    <select id="user_id" class="form-control">
      <option value="">-- pilih fotografer --</option>
      @foreach($fotografer as $f)
        <option value="{{ $f->id }}">
          {{ $f->username }} - {{ ucfirst(str_replace('_',' ', $f->role)) }}
        </option>
      @endforeach
    </select>
  </div>
</div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="btnSaveModal">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const csrf = '{{ csrf_token() }}';
  const modal = $('#reservasiModal');

  const f = id => document.getElementById(id);

  document.getElementById('btnTambah').onclick = () => {
    ['id_reservasi','nama','email','no_hp','tipe_paket','tanggal',
     'waktu_mulai','waktu_selesai','keterangan','user_id']
      .forEach(id => f(id).value = '');
    f('status').value = 'pending';
    modal.modal('show');
  };

  document.addEventListener('click', e => {
    if (e.target.classList.contains('btnEdit')) {
      const tr = e.target.closest('tr');
      if (e.target.classList.contains('btnEdit')) {
  const tr = e.target.closest('tr');

  f('id_reservasi').value  = tr.dataset.id || '';
  f('nama').value          = tr.dataset.nama || '';
  f('email').value         = tr.dataset.email || '';
  f('no_hp').value         = tr.dataset.no_hp || '';
  f('tipe_paket').value    = tr.dataset.tipe_paket || '';
  f('tanggal').value       = tr.dataset.tanggal || '';
  f('waktu_mulai').value   = tr.dataset.waktu_mulai || '';
  f('waktu_selesai').value = tr.dataset.waktu_selesai || '';
  f('keterangan').value    = tr.dataset.keterangan || '';
  f('status').value        = tr.dataset.status || 'pending';
  f('user_id').value       = tr.dataset.user_id || '';

  modal.modal('show');
}

      modal.modal('show');
    }

    if (e.target.classList.contains('btnHapus')) {
      if (!confirm('Hapus reservasi?')) return;
      fetch('/reservasi/delete',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf},
        body:JSON.stringify({id:e.target.closest('tr').dataset.id})
      }).then(()=>location.reload());
    }
  });

  document.getElementById('btnSaveModal').onclick = async () => {
    const payload = {
      id: f('id_reservasi').value || null,
      user_id: f('user_id').value || null,
      nama: f('nama').value,
      email: f('email').value,
      no_hp: f('no_hp').value,
      tipe_paket: f('tipe_paket').value || null,
      tanggal: f('tanggal').value,
      waktu_mulai: f('waktu_mulai').value+':00',
      waktu_selesai: f('waktu_selesai').value+':00',
      keterangan: f('keterangan').value || null,
      status: f('status').value
    };

    const url = payload.id ? '/reservasi/update' : '/reservasi/store';

    const res = await fetch(url,{
      method:'POST',
      headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf},
      body:JSON.stringify(payload)
    });

    if(!res.ok){ alert((await res.json()).message); return; }
    modal.modal('hide'); location.reload();
  };
});
</script>
@endpush
