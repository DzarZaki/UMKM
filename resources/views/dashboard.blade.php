@extends('layouts.dashboard')

@section('title','Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <a href="#" TOMBOL GENERATE REPORT class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report </a>
</div>
<!-- Content Row -->
<div class="row">
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Earnings (Monthly) </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"> $40,000 </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Earnings (Annual) </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"> $215,000 </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Tasks </div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> 50% </div>
              </div>
              <div class="col">
                <div class="progress progress-sm mr-2">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Pending Requests </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"> 18 </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-comments fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content Row -->
<div class="row">

  <!-- KIRI: Kalender -->
  <div class="col-lg-8 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kalender</h6>
      </div>
      <div class="card-body">
        <div id="calendar"></div>
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
<div class="modal fade" id="eventModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Reservasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_kalender">
            <div class="mb-2">
              <label>Nama Klien</label>
              <input type="text" id="nama_klien" class="form-control">
            </div>
            <div class="mb-2">
              <label>No HP</label>
              <input type="text" id="nomor_hp" class="form-control">
            </div>
            <div class="mb-2">
              <label>Email</label>
              <input type="email" id="email" class="form-control">
            </div>
            <div class="row mb-2">
              <div class="col">
                <label>Jam Mulai</label>
                <input type="time" id="start_time" class="form-control">
              </div>
              <div class="col">
                <label>Jam Selesai</label>
                <input type="time" id="end_time" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger d-none" id="deleteBtn">Hapus</button>
            <button class="btn btn-primary" id="saveBtn">Simpan</button>
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

  // ====== Modal helpers (SB Admin 2 / Bootstrap 4) ======
  function showModal() { $('#eventModal').modal('show'); }
  function hideModal() { $('#eventModal').modal('hide'); }

  // ====== Form elements ======
  const id_kalender = document.getElementById('id_kalender');
  const nama_klien  = document.getElementById('nama_klien');
  const start_time  = document.getElementById('start_time');
  const end_time    = document.getElementById('end_time');
  const nomor_hp    = document.getElementById('nomor_hp');
  const email       = document.getElementById('email');
  const saveBtn     = document.getElementById('saveBtn');
  const deleteBtn   = document.getElementById('deleteBtn');

  let selectedDate = null;

  function clearForm() {
    id_kalender.value = '';
    nama_klien.value  = '';
    nomor_hp.value    = '';
    email.value       = '';
    start_time.value  = '';
    end_time.value    = '';
    selectedDate      = null;
    deleteBtn.classList.add('d-none');
  }

  // ====== Local date/time helpers (ANTI UTC) ======
  function pad(n){ return String(n).padStart(2,'0'); }

  function toLocalDateStr(d) {
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
  }

  function toLocalTimeStr(d) {
    return `${pad(d.getHours())}:${pad(d.getMinutes())}:00`;
  }

  // startStr kadang sudah ISO-like, tapi aman ambil dari Date object:
  function infoStartDate(info) {
    return info.start instanceof Date ? toLocalDateStr(info.start) : info.startStr.substring(0,10);
  }
      //debug CONSOLE
  function logApi(label, payload, res, text) {
  console.group(`[${label}]`);
  console.log('payload:', payload);
  console.log('status:', res.status, res.statusText);
  try { console.log('response:', text ? JSON.parse(text) : text); }
  catch { console.log('response:', text); }
  console.groupEnd();
  }

  // ====== FullCalendar ======
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'timeGridWeek',
    timeZone: 'local',
    height: 600,
    contentHeight: 600,
    locale: 'id',
    selectable: true,
    editable: true,
    allDaySlot: false,
    themeSystem: 'bootstrap4',

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },

    events: '/kalender/load',

    // CREATE
    select(info) {
      clearForm();

      selectedDate = infoStartDate(info);

      start_time.value = '08:00';
      end_time.value   = '09:00';

      showModal();
    },

    // EDIT
    eventClick(info) {
      const e = info.event;

      id_kalender.value = e.id;
      nama_klien.value  = e.title;
      nomor_hp.value    = e.extendedProps.nomor_hp ?? '';
      email.value       = e.extendedProps.email ?? '';

      // pakai jam lokal (JANGAN toISOString)
      start_time.value = `${pad(e.start.getHours())}:${pad(e.start.getMinutes())}`;
      end_time.value   = e.end ? `${pad(e.end.getHours())}:${pad(e.end.getMinutes())}` : '';

      selectedDate = toLocalDateStr(e.start);

      deleteBtn.classList.remove('d-none');
      showModal();
    },

    // DRAG
    eventDrop: async function(info) {
      try { await updateEventTime(info.event); }
      catch (e) { info.revert(); alert('Gagal update (drag).'); }
    },

    // RESIZE
    eventResize: async function(info) {
      try { await updateEventTime(info.event); }
      catch (e) { info.revert(); alert('Gagal update (resize).'); }
    }
  });

  calendar.render();

  // ====== API calls ======
async function updateEventTime(event) {
  const payloadUpdate = {
    id: event.id,
    tanggal: toLocalDateStr(event.start),
    waktu_mulai: toLocalTimeStr(event.start),
    waktu_selesai: event.end ? toLocalTimeStr(event.end) : toLocalTimeStr(event.start),
  };

  const resUpdate = await fetch('/kalender/update', {
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
  logApi('UPDATE', payloadUpdate, resUpdate, textUpdate);

  if (!resUpdate.ok) throw new Error('update failed');
}

// SAVE (CREATE + UPDATE)
saveBtn.onclick = async () => {
  if (!selectedDate) { alert('Tanggal belum dipilih'); return; }
  if (!start_time.value || !end_time.value || start_time.value >= end_time.value) {
    alert('Jam tidak valid');
    return;
  }
  if (!nama_klien.value.trim()) {
    alert('Nama klien wajib diisi');
    return;
  }

  const payloadStore = {
    id_kalender: id_kalender.value || null,
    user_id: 1, // nanti ganti auth()->id()
    nama_klien: nama_klien.value,
    nomor_hp: nomor_hp.value,
    email: email.value,
    tanggal: selectedDate,
    waktu_mulai: start_time.value + ':00',
    waktu_selesai: end_time.value + ':00',
  };

  try {
    const resStore = await fetch('/kalender/store', {
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
    logApi('STORE', payloadStore, resStore, textStore);

    if (!resStore.ok) {
      alert('Gagal simpan. Cek console.');
      return;
    }

    hideModal();
    calendar.unselect();
    calendar.refetchEvents();

  } catch (e) {
    console.error('[STORE] exception:', e);
    alert('STORE error. Cek console.');
  }
};

// DELETE
deleteBtn.onclick = async () => {
  const id = id_kalender.value;
  if (!id) return;
  if (!confirm('Hapus event ini?')) return;

  const payloadDelete = { id };

  try {
    const resDelete = await fetch('/kalender/delete', {
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
      alert('Gagal hapus. Cek console.');
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
</script>
@endpush


