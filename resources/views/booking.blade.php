@extends('layouts.app')

@section('title','Booking')

@section('content')
<div class="container py-5">
  <div class="row justify-content-start g-4">

    {{-- Kolom kiri: Form --}}
    <div class="col-12 col-lg-6">
      <h3 class="mb-4">Get In Touch</h3>

      @if (session('success'))
      <div class="notice notice-success" role="alert">
        <div class="notice-dot"></div>
        <div class="notice-body">
          <div class="notice-title">Booking Berhasil</div>
          <div class="notice-text">{!! session('success') !!}</div>
        </div>
      </div>
    @endif


      <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
  @csrf

  {{-- Honeypot --}}
  <div class="hp">
    <label>Website</label>
    <input type="text" name="website" tabindex="-1" autocomplete="off">
  </div>

  {{-- Anti-bot cepat --}}
  <input type="hidden" name="_ts" value="{{ now()->timestamp }}">

  <div class="form-grid">
    <div>
      <input class="form-modern" name="nama" placeholder="Nama" type="text" required value="{{ old('nama') }}">
    </div>
    <div>
      <input class="form-modern" name="email" placeholder="Email" type="email" required value="{{ old('email') }}">
    </div>

    <div>
      <input
        type="tel"
        class="form-modern"
        name="no_hp"
        placeholder="Nomor WhatsApp (08xxxx / 62xxxx)"
        pattern="^(08|62)[0-9]{8,12}$"
        title="Nomor harus diawali 08 atau 62"
        minlength="9"
        maxlength="15"
        inputmode="numeric"
        required
        value="{{ old('no_hp') }}"
        class="form-modern"
      >
      <!-- <small class="hint">Contoh: 0812xxxx atau +62812xxxx</small> -->
    </div>

    <div>
      <input class="form-modern" name="tipe_paket" placeholder="Tipe Paket (Opsional)" value="{{ old('tipe_paket') }}">
      <small class="hint">
  <a href="https://drive.google.com/file/d/18_nfvGHXI-E4hhz19Y9fEqP8pEyh1Bnn/view"
     target="_blank"
     style="color:#aaa;text-decoration:underline">
     Lihat PRICELIST Kami Untuk Referensi
  </a>
</small>

    </div>

    <div>
      <label class="mini-label">Tanggal</label>
      <input
        type="date"
        class="form-modern"
        name="tanggal"
        required
        min="{{ now()->toDateString() }}"
        value="{{ old('tanggal') }}"
      >
    </div>

    <div class="time-row">
      <div>
        <label class="mini-label">Mulai</label>
        <input type="time" name="waktu_mulai" class="form-modern" value="{{ old('waktu_mulai','08:00') }}" required>
      </div>
      <div>
        <label class="mini-label">Selesai</label>
        <input type="time" name="waktu_selesai" class="form-modern" value="{{ old('waktu_selesai','09:00') }}" required>
      </div>
    </div>
  </div>

  {{-- Box Ketersediaan --}}
  <div id="availabilityBox" class="availability-box" style="display:none;">
    <div class="availability-head">
      <div class="availability-icon" id="availabilityIcon"></div>
      <div>
        <div class="availability-title" id="availabilityTitle">Ketersediaan</div>
        <div class="availability-desc" id="availabilityDesc"></div>
      </div>
    </div>

    <div class="waiting-wrap" id="waitingListWrap" style="display:none;">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="waiting_list" name="waiting_list" value="1">
        <label class="custom-control-label" for="waiting_list">
          Masukkan saya ke <b>waiting list</b>
        </label>
      </div>
      <small class="hint mt-2 d-block">
        Jika ada slot kosong/cancel, admin akan menghubungi kamu.
      </small>
    </div>
  </div>

  <div class="mt-2">
    <textarea class="form-modern" name="keterangan" placeholder="Keterangan (Opsional)" rows="4">{{ old('keterangan') }}</textarea>
  </div>

  <button type="submit" class="btn-submit btn-submit-block">
    KIRIM BOOKING
  </button>

  <small class="form-note d-block mt-3">
    Setelah booking dikirim, admin akan menghubungi kamu untuk konfirmasi.
  </small>
</form>
</div>


    {{-- Kolom kanan: Kalender mirror --}}
    <!-- <div class="col-12 col-lg-6">
        <div class ="pt-3">
      <div class="mb-2 d-flex justify-content-between align-items-center">
        <h5 class="mb-1 "></h5>
        <small class="text-muted">Booked = terisi</small>
      </div>
      </div> -->

      <!-- @include('partials.mirrorCalendar') -->
    </div>

  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const tanggalEl = document.querySelector('input[name="tanggal"]');
  const box = document.getElementById('availabilityBox');

  const iconEl  = document.getElementById('availabilityIcon');
  const titleEl = document.getElementById('availabilityTitle');
  const descEl  = document.getElementById('availabilityDesc');

  const waitingWrap = document.getElementById('waitingListWrap');
  const waitingCb   = document.getElementById('waiting_list');

  if (!tanggalEl || !box) return;

  async function loadAvailability(tanggal) {
    if (!tanggal) {
      box.style.display = 'none';
      return;
    }

    const url = `{{ route('booking.availability') }}?tanggal=${encodeURIComponent(tanggal)}`;
    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
    const data = await res.json();

    if (!data.ok) {
      box.style.display = 'none';
      return;
    }

    box.style.display = 'block';

    titleEl.textContent = data.title || 'Ketersediaan';
    descEl.textContent  = data.desc  || '';

    // reset classes
    box.classList.remove('alert-success','alert-warning','alert-danger','alert-secondary');

    // default hidden
    // if (waitingWrap) waitingWrap.style.display = 'none';

    // if (data.level === 'ok') {
    //   box.classList.add('alert-success');
    //   if (iconEl) iconEl.textContent = '✅';
    //   if (waitingCb) waitingCb.checked = false;

    // } else if (data.level === 'low') {
    //   box.classList.add('alert-warning');
    //   if (iconEl) iconEl.textContent = '⚠️';
    //   if (waitingCb) waitingCb.checked = false;

    // } else { // full
    //   box.classList.add('alert-danger');
    //   if (iconEl) iconEl.textContent = '⛔';

    //   if (waitingWrap) waitingWrap.style.display = 'block';
    //   if (waitingCb) waitingCb.checked = true; // ✅ auto-centang saat penuh
    // }

    // icon dot color
const dot = document.getElementById('availabilityIcon');

if (data.level === 'ok') {
  dot.style.background = 'rgba(40, 167, 69, .8)';      // green-ish
  waitingWrap.style.display = 'none';
  waitingCb.checked = false;
} else if (data.level === 'low') {
  dot.style.background = 'rgba(255, 193, 7, .85)';     // yellow-ish
  waitingWrap.style.display = 'none';
  waitingCb.checked = false;
} else {
  dot.style.background = 'rgba(220, 53, 69, .85)';     // red-ish
  waitingWrap.style.display = 'block';
  waitingCb.checked = true; // auto-centang saat penuh
}

  }

  // initial (kalau sudah ada value)
  if (tanggalEl.value) loadAvailability(tanggalEl.value);

  // update saat ganti tanggal
  tanggalEl.addEventListener('change', function () {
    loadAvailability(this.value);
  });
});
</script>


@endsection
