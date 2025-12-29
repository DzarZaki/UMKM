@extends('layouts.dashboard')

@section('content')
<style>
  /* area tabel yang scroll (bukan page) */
  .reservasi-table-wrap{
    max-height: calc(100vh - 350px); /* sesuaikan kalau header layout kamu lebih tinggi/rendah */
    overflow-y: auto;
    overflow-x: auto;
  }

  /* sticky header */
  .reservasi-table-wrap thead th{
    position: sticky;
    top: 0;
    z-index: 3;
    background: #f8f9fc; /* mirip bg-light */
    border-top: 0;
  }

  /* supaya sticky stabil di beberapa browser */
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

    <div class="col-md-3 mb-2">
      <select name="tipe_paket" class="form-control">
        <option value="">-- Semua Paket --</option>
        @foreach($paketOptions as $p)
          <option value="{{ $p }}" {{ request('tipe_paket')===$p ? 'selected' : '' }}>
            {{ $p }}
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

  @if(request()->hasAny(['status','tipe_paket','q']))
    <a href="{{ route('reservasi.index') }}" class="btn btn-link p-0">Reset</a>
  @endif
</form>

{{-- Tombol Tambah (MODAL) --}}
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
        <thead class="bg-light">
          <tr>
            <th width="50">No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Fotografer</th>
            <th>Tipe Paket</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
            <th width="160">Aksi</th>
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
    default => 'secondary'
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
  data-id_fotografer="{{ $item->id_fotografer ?? '' }}"
>
  <td>{{ ($reservasi->currentPage()-1)*$reservasi->perPage() + $loop->iteration }}</td>

  <td>{{ $item->nama }}</td>

  <td>{{ $item->email }}</td>

  <td>
    {{ $item->no_hp }}
   <a
              href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_hp) }}"
              target="_blank"
              class="text-muted ml-2"
              title="Chat WhatsApp">
              <i class="fas fa-external-link-alt fa-xs"></i>
            </a>
  </td>

  <td>{{ $item->fotografer?->nama_fotografer ?? '-' }}</td>

  <td>{{ $item->tipe_paket ?? '-' }}</td>

  <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>

  {{-- ✅ KOLOM WAKTU (INI YANG HILANG) --}}
  <td>
    {{ substr($item->waktu_mulai,0,5) }} - {{ substr($item->waktu_selesai,0,5) }}
  </td>

  <td>
    <span class="badge badge-{{ $badge }}">
      {{ ucfirst(str_replace('_',' ', $item->status)) }}
    </span>
  </td>

  <td>
    <button type="button" class="btn btn-sm btn-warning btnEdit">Edit</button>
    <button type="button" class="btn btn-sm btn-danger btnHapus">Hapus</button>
  </td>
</tr>

@empty
<tr>
  <td colspan="10" class="text-center text-muted">
    Belum ada data reservasi
  </td>
</tr>
@endforelse
</tbody>

    </table>

    {{-- pagination --}}
<div class="d-flex justify-content-center mt-3">
    {{ $reservasi->links('pagination::bootstrap-4') }}
</div>

  </div>
</div>

{{-- MODAL CRUD --}}
<div class="modal fade" id="reservasiModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header py-2">
        <h5 class="modal-title mb-0" id="modalTitle">Reservasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body pt-3 pb-2">
        <input type="hidden" id="id_reservasi">

        <div class="row">
          <!-- KIRI -->
          <div class="col-md-6">
            <div class="form-group mb-2">
              <label class="mb-1">Nama</label>
              <input type="text" id="nama" class="form-control">
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">Email</label>
              <input type="email" id="email" class="form-control">
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">No HP</label>
              <input type="text" id="no_hp" class="form-control">
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">Tipe Paket (opsional)</label>
              <input type="text" id="tipe_paket" class="form-control">
            </div>

            <div class="form-group mb-0">
              <label class="mb-1">Keterangan (opsional)</label>
              <textarea id="keterangan" class="form-control" rows="5"></textarea>
            </div>
          </div>

          <!-- KANAN -->
          <div class="col-md-6">
            <div class="form-row">
              <div class="form-group col-md-6 mb-2">
                <label class="mb-1">Tanggal</label>
                <input type="date" id="tanggal" class="form-control">
              </div>

              <div class="form-group col-md-6 mb-2">
                <label class="mb-1">Status</label>
                <select id="status" class="form-control">
                  <option value="new">New</option>
                  <option value="pending">Pending</option>
                  <option value="in_progress">In Progress</option>
                  <option value="done">Done</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6 mb-2">
                <label class="mb-1">Waktu Mulai</label>
                <input type="time" id="waktu_mulai" class="form-control">
              </div>

              <div class="form-group col-md-6 mb-2">
                <label class="mb-1">Waktu Selesai</label>
                <input type="time" id="waktu_selesai" class="form-control">
              </div>
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">Fotografer</label>
              <select id="id_fotografer" class="form-control">
                <option value="">-- pilih fotografer --</option>
                @foreach($fotografer as $f)
                  <option value="{{ $f->id }}">
                    {{ $f->nama_fotografer }}{{ $f->spesialisasi ? ' - '.$f->spesialisasi : '' }}
                  </option>
                @endforeach
              </select>
            </div>
            </div>

          </div>
        </div>
      </div>

      <div class="modal-footer py-2">
        <!-- <button type="button" class="btn btn-danger d-none" id="btnDeleteModal">Hapus</button> -->
        <button type="button" class="btn btn-primary" id="btnSaveModal">Simpan</button>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrf = '{{ csrf_token() }}';
  const modal = $('#reservasiModal');

  const id_reservasi  = document.getElementById('id_reservasi');
  const nama          = document.getElementById('nama');
  const email         = document.getElementById('email');
  const no_hp         = document.getElementById('no_hp');
  const tipe_paket    = document.getElementById('tipe_paket');
  const tanggal       = document.getElementById('tanggal');
  const waktu_mulai   = document.getElementById('waktu_mulai');
  const waktu_selesai = document.getElementById('waktu_selesai');
  const keterangan    = document.getElementById('keterangan');
  const statusEl      = document.getElementById('status');
  const id_fotografer = document.getElementById('id_fotografer');
 

  /* =====================
     TAMBAH
  ===================== */
  document.getElementById('btnTambah')?.addEventListener('click', function () {
    id_reservasi.value = '';
    nama.value = '';
    email.value = '';
    no_hp.value = '';
    tipe_paket.value = '';
    tanggal.value = '';
    waktu_mulai.value = '';
    waktu_selesai.value = '';
    keterangan.value = '';
    statusEl.value = 'pending';
    id_fotografer.value = '';
    modal.modal('show');
  });

  /* =====================
     EVENT DELEGATION
     (EDIT & HAPUS)
  ===================== */
  document.addEventListener('click', async function (e) {

    /* ===== EDIT ===== */
    if (e.target.classList.contains('btnEdit')) {
      const tr = e.target.closest('tr');
      if (!tr) return;

      id_reservasi.value  = tr.dataset.id || '';
      nama.value          = tr.dataset.nama || '';
      email.value         = tr.dataset.email || '';
      no_hp.value         = tr.dataset.no_hp || '';
      tipe_paket.value    = tr.dataset.tipe_paket || '';
      tanggal.value       = tr.dataset.tanggal || '';
      waktu_mulai.value   = tr.dataset.waktu_mulai || '';
      waktu_selesai.value = tr.dataset.waktu_selesai || '';
      keterangan.value    = tr.dataset.keterangan || '';
      statusEl.value      = tr.dataset.status || 'pending';
      id_fotografer.value = tr.dataset.id_fotografer || '';

      modal.modal('show');
    }

    /* ===== HAPUS ===== */
    if (e.target.classList.contains('btnHapus')) {
      const tr = e.target.closest('tr');
      if (!tr) return;

      if (!confirm('Hapus data reservasi?')) return;

      const res = await fetch('/reservasi/delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ id: tr.dataset.id })
      });

      if (!res.ok) {
        const err = await res.json();
        alert(err.message || 'Gagal hapus data');
        return;
      }

      location.reload();
    }

  });

  /* =====================
     SIMPAN (CREATE / UPDATE)
  ===================== */
  document.getElementById('btnSaveModal')?.addEventListener('click', async function () {
    if (!nama.value.trim()) return alert('Nama wajib diisi');
    if (!tanggal.value) return alert('Tanggal wajib diisi');
    if (!waktu_mulai.value || !waktu_selesai.value || waktu_mulai.value >= waktu_selesai.value) {
      return alert('Jam tidak valid');
    }

    const isUpdate = !!id_reservasi.value;

    const payload = {
      id: isUpdate ? Number(id_reservasi.value) : null,
      id_fotografer: id_fotografer.value ? Number(id_fotografer.value) : null,


      nama: nama.value,
      email: email.value,
      no_hp: no_hp.value,
      tipe_paket: tipe_paket.value || null,

      tanggal: tanggal.value,
      waktu_mulai: waktu_mulai.value + ':00',
      waktu_selesai: waktu_selesai.value + ':00',

      keterangan: keterangan.value || null,
      status: statusEl.value,
    };

    const url = isUpdate ? '/reservasi/update' : '/reservasi/store';

    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json',
      },
      body: JSON.stringify(payload)
    });

    if (!res.ok) {
      const err = await res.json();
      alert(err.message || 'Terjadi kesalahan');
      return;
    }

    modal.modal('hide');
    location.reload();
  });
//   btnDelete.addEventListener('click', async function() {
//     const id = id_reservasi.value;
//     if (!id) return;
//     if (!confirm('Hapus data reservasi?')) return;

//     const res = await fetch('/reservasi/delete', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': csrf,
//         'Accept': 'application/json',
//       },
//       credentials: 'same-origin',
//       body: JSON.stringify({ id: Number(id) })
//     });

//     if (!res.ok) {
//       alert('Gagal hapus. Cek console/network.');
//       console.log(await res.text());
//       return;
//     }

//     modal.modal('hide');
//     location.reload();
//   });
});
</script>
@endpush
