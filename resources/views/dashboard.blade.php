@extends('layouts.dashboard')

@section('title','Dashboard')

@section('content')
<style>
  .dashboard-list-scroll{
    max-height: 620px;
    overflow-y: auto;
  }
  .dashboard-list-scroll thead th{
    position: sticky;
    top: 0;
    z-index: 2;
    background: #f8f9fc; /* mirip thead-light */
  }
  .dashboard-list-scroll table{
    border-collapse: separate;
    border-spacing: 0;
  }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<!-- Content Row: KIRI (Stat + Kalender) | KANAN (List Reservasi) -->
<div class="row">

  <!-- KIRI -->
  <div class="col-lg-8">

    {{-- ================= STATISTIK ================= --}}
<div class="row">

  {{-- ===== ADMIN ===== --}}
  @if(auth()->user()->role === 'admin')

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
            New Reservation
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $stats['new'] ?? 0 }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
            Pending
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $stats['pending'] ?? 0 }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
            In Progress
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $stats['in_progress'] ?? 0 }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Done
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $stats['done'] ?? 0 }}
          </div>
        </div>
      </div>
    </div>

  {{-- ===== FOTOGRAFER ===== --}}
  @else

    <div class="col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
            Pekerjaan Ditugaskan
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $stats['assigned'] ?? 0 }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Pekerjaan Selesai
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $stats['done'] ?? 0 }}
          </div>
        </div>
      </div>
    </div>

  @endif
</div>
{{-- ================= END STATISTIK ================= --}}


    <!-- Kalender -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kalender</h6>
      </div>
      <div class="card-body">
        <div id="calendar"></div>
      </div>
    </div>

  </div>

  <!-- KANAN: List Reservasi (naik sejajar dari atas) -->
  <div class="col-lg-4">
    <div class="card shadow-sm border-0 h-200 mb-4">
      <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <div>
          <h6 class="m-0 font-weight-bold text-primary">Reservasi</h6>
          <small class="text-muted">Terbaru</small>
        </div>

        <a href="{{ route('reservasi.index') }}" class="btn btn-sm btn-outline-primary">
          Lihat semua
        </a>
      </div>

      <div class="card-body pt-3 pb-2">
        <!-- Filter -->
        <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text bg-light">Status</span>
            </div>
            <select name="status" id="filter_status" class="form-control" onchange="this.form.submit()">
              <option value="">Semua</option>
              <option value="new" {{ request('status')==='new' ? 'selected' : '' }}>New</option>
              <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
              <option value="in_progress" {{ request('status')==='in_progress' ? 'selected' : '' }}>In Progress</option>
              <option value="done" {{ request('status')==='done' ? 'selected' : '' }}>Done</option>
            </select>
          </div>

          @if(request('status'))
            <div class="mt-1">
              <a href="{{ route('dashboard') }}" class="small">Reset</a>
            </div>
          @endif
        </form>

        <!-- List -->
        <div class="table-responsive dashboard-list-scroll">
          <table class="table table-sm table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>Nama</th>
                <th>Status</th>
                <th class="text-center" width="46">Detail</th>
              </tr>
            </thead>
            <tbody>

            @forelse($reservasi_list as $r)
              @php
                $badge = match($r->status) {
                  'new' => 'light',
                  'pending' => 'warning',
                  'in_progress' => 'info',
                  'done' => 'success',
                  default => 'secondary'
                };
                $label = ucfirst(str_replace('_',' ', $r->status));
              @endphp

              <tr>
                <td class="align-middle">
                  <div class="font-weight-bold text-dark">{{ $r->nama }}</div>
                  <div class="small text-muted">{{ $r->no_hp }}</div>
                </td>

                <td class="align-middle">
                  <span class="badge badge-{{ $badge }}">{{ $label }}</span>
                  <div class="small text-muted mt-1">
                    {{ \Carbon\Carbon::parse($r->tanggal)->format('d M') }},
                    {{ substr($r->waktu_mulai,0,5) }}-{{ substr($r->waktu_selesai,0,5) }}
                  </div>
                </td>

                <td class="text-center align-middle">
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-primary btnViewDetail"
                    title="Lihat detail"
                    data-id="{{ $r->id }}"
                    data-nama="{{ e($r->nama) }}"
                    data-no_hp="{{ e($r->no_hp) }}"
                    data-email="{{ e($r->email) }}"
                    data-tipe_paket="{{ e($r->tipe_paket ?? '') }}"
                    data-status="{{ $r->status }}"
                    data-id_fotografer="{{ $r->id_fotografer ?? '' }}"
                    data-keterangan="{{ e($r->keterangan ?? '') }}"
                    data-waktu_mulai="{{ substr($r->waktu_mulai,0,5) }}"
                    data-waktu_selesai="{{ substr($r->waktu_selesai,0,5) }}"
                    data-tanggal="{{ $r->tanggal }}"
                  >
                    <i class="fas fa-eye"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center text-muted py-4">
                  Belum ada reservasi
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
              
    </div>
  </div>
</div>


  <!-- Content Column -->
  <div class="col-lg-8 mb-4">
    <!-- Project Card Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
      </div>
      <div class="card-body">
        <!-- Color System -->
        <div class="row">
          <div class="col-lg-6 mb-4">
            <div class="card bg-primary text-white shadow">
              <div class="card-body"> Primary <div class="text-white-50 small">#4e73df</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-success text-white shadow">
              <div class="card-body"> Success <div class="text-white-50 small">#1cc88a</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-info text-white shadow">
              <div class="card-body"> Info <div class="text-white-50 small">#36b9cc</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-warning text-white shadow">
              <div class="card-body"> Warning <div class="text-white-50 small">#f6c23e</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-danger text-white shadow">
              <div class="card-body"> Danger <div class="text-white-50 small">#e74a3b</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-secondary text-white shadow">
              <div class="card-body"> Secondary <div class="text-white-50 small">#858796</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-light text-black shadow">
              <div class="card-body"> Light <div class="text-black-50 small">#f8f9fc</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card bg-dark text-white shadow">
              <div class="card-body"> Dark <div class="text-white-50 small">#5a5c69</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
<!-- == MODAL == -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header py-2">
        <h5 class="modal-title mb-0">Reservasi</h5>
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
              <input type="text" id="nama_klien" class="form-control">
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">No HP</label>
              <input type="text" id="nomor_hp" class="form-control">
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">Email</label>
              <input type="email" id="email" class="form-control">
            </div>

            <div class="form-group mb-2">
              <label class="mb-1">Tipe Paket</label>
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
                <label class="mb-1">Status</label>
                <select id="status" class="form-control">
                  <option value="new">New</option>
                  <option value="pending">Pending</option>
                  <option value="in_progress">In Progress</option>
                  <option value="done">Done</option>
                </select>
              </div>

              <div class="form-group col-md-6 mb-2">
                <label class="mb-1">Fotografer</label>
                <select id="fotografer" class="form-control">
                  <option value="">-- pilih fotografer --</option>
                  @foreach($fotografer as $f)
                    <option value="{{ $f->id }}">
                      {{ $f->nama_fotografer }}{{ $f->spesialisasi ? ' - '.$f->spesialisasi : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6 mb-0">
                <label class="mb-1">Jam Mulai</label>
                <input type="time" id="start_time" class="form-control" value="08:00">
              </div>

              <div class="form-group col-md-6 mb-0">
                <label class="mb-1">Jam Selesai</label>
                <input type="time" id="end_time" class="form-control" value="09:00">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="modal-footer py-2">
        <button type="button" class="btn btn-danger d-none" id="deleteBtn">Hapus</button>
        <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
      </div>

    </div>
  </div>
</div>


<!-- End of Main Content -->
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  if (!calendarEl) return;

  // ====== Modal helpers (Bootstrap 4 + jQuery) ======
  function showModal() { $('#eventModal').modal('show'); }
  function hideModal() { $('#eventModal').modal('hide'); }

  // ====== Form elements ======
  const id_reservasi = document.getElementById('id_reservasi');
  const nama         = document.getElementById('nama_klien');
  const nomor_hp     = document.getElementById('nomor_hp');
  const email        = document.getElementById('email');
  const start_time   = document.getElementById('start_time');
  const end_time     = document.getElementById('end_time');
  const saveBtn      = document.getElementById('saveBtn');
  const deleteBtn    = document.getElementById('deleteBtn');

  // optional fields
  const tipe_paket   = document.getElementById('tipe_paket');
  const keterangan   = document.getElementById('keterangan');
  const statusEl     = document.getElementById('status');
  const fotograferEl = document.getElementById('fotografer');

  let selectedDate = null;

  // ====== helpers ======
  function pad(n){ return String(n).padStart(2,'0'); }

  function toLocalDateStr(d) {
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
  }

  function toLocalTimeStr(d) {
    return `${pad(d.getHours())}:${pad(d.getMinutes())}:00`;
  }

  function infoStartDate(info) {
    return info.start instanceof Date ? toLocalDateStr(info.start) : info.startStr.substring(0,10);
  }

  function clearForm() {
    id_reservasi.value = '';
    nama.value = '';
    nomor_hp.value = '';
    email.value = '';
    start_time.value = '';
    end_time.value = '';
    selectedDate = null;

    if (tipe_paket) tipe_paket.value = '';
    if (keterangan) keterangan.value = '';
    if (statusEl) statusEl.value = 'pending';
    if (fotograferEl) fotograferEl.value = '';

    deleteBtn.classList.add('d-none');
  }

  function logApi(label, payload, res, text) {
    console.group(`[${label}]`);
    console.log('payload:', payload);
    console.log('status:', res.status, res.statusText);
    try { console.log('response:', text ? JSON.parse(text) : text); }
    catch { console.log('response:', text); }
    console.groupEnd();
  }

  function setReadOnly(isReadOnly) {
  const fields = [nama, nomor_hp, email, start_time, end_time, tipe_paket, keterangan, statusEl, fotograferEl].filter(Boolean);
  fields.forEach(el => el.disabled = isReadOnly);

  // sembunyikan tombol action saat detail
  saveBtn.classList.toggle('d-none', isReadOnly);
  deleteBtn.classList.toggle('d-none', true); // detail: selalu hide delete
}


  // ====== FullCalendar ======
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'timeGridWeek',
    timeZone: 'local',
    locale: 'id',
    selectable: false, // CREATE pake klik slot
    editable: false, // DRAG/RESIZE
    eventStartEditable: false, // extra aman (drag)
    eventDurationEditable: true, // extra aman (resize)
    allDaySlot: false,
    themeSystem: 'bootstrap4',
    height: 600,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },

    // events: '/calendar/events',
    events: {
    url: '/calendar/events',
    extraParams: function () {
      return {
        status: document.getElementById('filter_status')?.value || '',
        // kalau kamu mau include new via toggle:
        // include_new: document.getElementById('include_new')?.checked ? 1 : 0,
      };
    }},

    // CREATE (select slot) BUAT RESERVASI PAKE KLIK
    // select(info) {
    //   clearForm();
    //   selectedDate = infoStartDate(info);

    //   // pakai jam yang dipilih biar gak “geser”
    //   start_time.value = `${pad(info.start.getHours())}:${pad(info.start.getMinutes())}`;
    //   if (info.end) {
    //     end_time.value = `${pad(info.end.getHours())}:${pad(info.end.getMinutes())}`;
    //   } else {
    //     end_time.value = `${pad((info.start.getHours()+1)%24)}:${pad(info.start.getMinutes())}`;
    //   }

    //   showModal();
    // },

    eventClick(info) { //LIHAT DETAIL INFO, TIDAK BISA NYALA BERBARENGAN DENGAN EDIT
      const e = info.event;

      clearForm();              // optional, biar bersih
      setReadOnly(true);        // mode detail

      // isi data
      nama.value     = e.extendedProps.nama ?? '';
      nomor_hp.value = e.extendedProps.no_hp ?? '';
      email.value    = e.extendedProps.email ?? '';

      if (tipe_paket) tipe_paket.value = e.extendedProps.tipe_paket ?? '';
      if (keterangan) keterangan.value = e.extendedProps.keterangan ?? '';
      if (statusEl) statusEl.value = e.extendedProps.status ?? '';
      if (fotograferEl) fotograferEl.value = e.extendedProps.id_fotografer ?? '';

      start_time.value = `${pad(e.start.getHours())}:${pad(e.start.getMinutes())}`;
      end_time.value   = e.end ? `${pad(e.end.getHours())}:${pad(e.end.getMinutes())}` : '';

      selectedDate = toLocalDateStr(e.start);

      showModal();
    },


    // EDIT (click existing event) EDIT RESERVASI PAKE KLIK
    // eventClick(info) {
    //   const e = info.event;

    //   id_reservasi.value = e.id;

    //   // ambil dari extendedProps (sesuai controller events)
    //   nama.value     = e.extendedProps.nama ?? '';
    //   nomor_hp.value = e.extendedProps.no_hp ?? '';
    //   email.value    = e.extendedProps.email ?? '';

    //   if (tipe_paket) tipe_paket.value = e.extendedProps.tipe_paket ?? '';
    //   if (keterangan) keterangan.value = e.extendedProps.keterangan ?? '';
    //   if (statusEl) statusEl.value = e.extendedProps.status ?? 'pending';
    //   if (fotograferEl) fotograferEl.value = e.extendedProps.id_fotografer ?? '';

    //   start_time.value = `${pad(e.start.getHours())}:${pad(e.start.getMinutes())}`;
    //   end_time.value   = e.end ? `${pad(e.end.getHours())}:${pad(e.end.getMinutes())}` : '';

    //   selectedDate = toLocalDateStr(e.start);

    //   deleteBtn.classList.remove('d-none');
    //   showModal();
    // },

    // DRAG KALENDER
    // eventDrop: async function(info) {
    //   try { await updateEventTime(info.event); }
    //   catch (e) { info.revert(); alert('Gagal update (drag).'); }
    // },

    // RESIZE KALENDER
    // eventResize: async function(info) {
    //   try { await updateEventTime(info.event); }
    //   catch (e) { info.revert(); alert('Gagal update (resize).'); }
    // }
  });

  calendar.render();

  const statusDropdown = document.getElementById('filter_status');
  if (statusDropdown) {
    statusDropdown.addEventListener('change', function () {
      calendar.refetchEvents();
    });
  }


  // ====== API calls ======
  async function updateEventTime(event) {
    const payloadUpdate = {
      id: event.id,
      tanggal: toLocalDateStr(event.start),
      waktu_mulai: toLocalTimeStr(event.start),
      waktu_selesai: event.end ? toLocalTimeStr(event.end) : toLocalTimeStr(event.start),
    };

    const resUpdate = await fetch('/reservasi/update-time', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
      credentials: 'same-origin',
      body: JSON.stringify(payloadUpdate)
    });

    const textUpdate = await resUpdate.text();
    logApi('UPDATE-TIME', payloadUpdate, resUpdate, textUpdate);

    if (!resUpdate.ok) throw new Error('update-time failed');
  }

  // SAVE (CREATE + UPDATE)
  saveBtn.onclick = async () => {
    if (!selectedDate) { alert('Tanggal belum dipilih'); return; }
    if (!start_time.value || !end_time.value || start_time.value >= end_time.value) {
      alert('Jam tidak valid');
      return;
    }
    if (!nama.value.trim()) {
      alert('Nama wajib diisi');
      return;
    }

    const isUpdate = !!id_reservasi.value;

    const payloadStore = {
      id: isUpdate ? id_reservasi.value : null,
      id_fotografer: fotograferEl ? (fotograferEl.value || null) : null,

      nama: nama.value,
      email: email.value,
      no_hp: nomor_hp.value,

      tipe_paket: tipe_paket ? (tipe_paket.value || null) : null,
      tanggal: selectedDate,
      waktu_mulai: start_time.value + ':00',
      waktu_selesai: end_time.value + ':00',

      keterangan: keterangan ? (keterangan.value || null) : null,
      status: statusEl ? statusEl.value : 'pending',
    };

    const url = isUpdate ? '/reservasi/update' : '/reservasi/store';

    try {
      const resStore = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        credentials: 'same-origin',
        body: JSON.stringify(payloadStore)
      });

      const textStore = await resStore.text();
      logApi(isUpdate ? 'UPDATE' : 'STORE', payloadStore, resStore, textStore);

      if (!resStore.ok) {
        alert('Gagal simpan. Lihat console/network.');
        return;
      }

      hideModal();
      calendar.unselect();
      calendar.refetchEvents();

    } catch (e) {
      console.error('[STORE/UPDATE] exception:', e);
      alert('STORE/UPDATE error. Cek console.');
    }
  };

  // DELETE
  deleteBtn.onclick = async () => {
    const id = id_reservasi.value;
    if (!id) return;
    if (!confirm('Hapus reservasi ini?')) return;

    const payloadDelete = { id };

    try {
      const resDelete = await fetch('/reservasi/delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        credentials: 'same-origin',
        body: JSON.stringify(payloadDelete)
      });

      const textDelete = await resDelete.text();
      logApi('DELETE', payloadDelete, resDelete, textDelete);

      if (!resDelete.ok) {
        alert('Gagal hapus. Lihat console/network.');
        return;
      }

      hideModal();
      calendar.refetchEvents();

    } catch (e) {
      console.error('[DELETE] exception:', e);
      alert('DELETE error. Cek console.');
    }
  };
});

// ====== Detail view dari list reservasi (di samping kalender) ======
document.addEventListener('DOMContentLoaded', function () {
  // ambil elemen modal yang sudah ada
  const id_reservasi = document.getElementById('id_reservasi');
  const nama = document.getElementById('nama_klien');
  const nomor_hp = document.getElementById('nomor_hp');
  const email = document.getElementById('email');
  const tipe_paket = document.getElementById('tipe_paket');
  const statusEl = document.getElementById('status');
  const fotograferEl = document.getElementById('fotografer');
  const keterangan = document.getElementById('keterangan');
  const start_time = document.getElementById('start_time');
  const end_time = document.getElementById('end_time');

  const saveBtn = document.getElementById('saveBtn');
  const deleteBtn = document.getElementById('deleteBtn');

  function showModal() { $('#eventModal').modal('show'); }

  function setReadOnly(isReadOnly) {
    [nama, nomor_hp, email, tipe_paket, statusEl, fotograferEl, keterangan, start_time, end_time]
      .filter(Boolean)
      .forEach(el => el.disabled = isReadOnly);

    // detail mode: sembunyikan tombol simpan/hapus
    if (saveBtn) saveBtn.classList.toggle('d-none', isReadOnly);
    if (deleteBtn) deleteBtn.classList.add('d-none');
  }

  // klik tombol mata
  document.querySelectorAll('.btnViewDetail').forEach(btn => {
    btn.addEventListener('click', () => {
      setReadOnly(true);

      id_reservasi.value = btn.dataset.id || '';
      nama.value = btn.dataset.nama || '';
      nomor_hp.value = btn.dataset.no_hp || '';
      email.value = btn.dataset.email || '';
      if (tipe_paket) tipe_paket.value = btn.dataset.tipe_paket || '';
      if (statusEl) statusEl.value = btn.dataset.status || 'pending';
      if (fotograferEl) fotograferEl.value = btn.dataset.id_fotografer || '';
      if (keterangan) keterangan.value = btn.dataset.keterangan || '';

      // time inputs butuh HH:MM
      if (start_time) start_time.value = btn.dataset.waktu_mulai || '';
      if (end_time) end_time.value = btn.dataset.waktu_selesai || '';

      showModal();
    });
  });

  // saat modal ditutup, balikin editable lagi (biar fitur create/edit modal tetap normal)
  $('#eventModal').on('hidden.bs.modal', function () {
    setReadOnly(false);
  });
});


</script>

@endpush

<!-- <style>
/* status */
.status-new { background:#e2e6ea !important; border-color:#e2e6ea !important; color:#111 !important; }
.status-pending { background:#f6c23e !important; border-color:#f6c23e !important; }
.status-in_progress { background:#36b9cc !important; border-color:#36b9cc !important; }
.status-done { background:#1cc88a !important; border-color:#1cc88a !important; }

/* opsional: paket (kalau lo kirim class paket-xxx) */
.paket-wedding { background:#4e73df !important; border-color:#4e73df !important; }
</style> -->
