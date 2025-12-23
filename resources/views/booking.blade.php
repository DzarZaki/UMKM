@extends('layouts.app')

@section('title','Booking')

@section('content')
<div class="container py-5">
  <div class="row justify-content-start g-4">

    {{-- Kolom kiri: Form --}}
    <div class="col-12 col-lg-6">
      <h3 class="text-center mb-4">Get In Touch</h3>

      @if (session('success'))
        <div class="alert alert-success text-center">
          {!! session('success') !!}
        </div>
      @endif

      <form action="{{ route('booking.store') }}" method="POST">
        @csrf

        <input class="form-control mb-3" name="nama" placeholder="Nama" required>
        <input class="form-control mb-3" name="email" placeholder="Email" required>
        <input class="form-control mb-3" name="no_hp" placeholder="Nomor Handphone / WhatsApp aktif" required>

        <input class="form-control mb-3" name="tipe_paket" placeholder="Tipe Paket (Opsional)">

        <input type="date" class="form-control mb-3" name="tanggal" required>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Waktu Mulai</label>
            <input type="time" name="waktu_mulai" class="form-control" value="08:00" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Waktu Selesai</label>
            <input type="time" name="waktu_selesai" class="form-control" value="09:00"  required>
          </div>
        </div>

        <textarea
          class="form-control mb-3"
          name="keterangan"
          placeholder="Keterangan (Opsional)"
          rows="4"
        ></textarea>

        <button type="submit" class="btn btn-primary w-100">
          Kirim Booking
        </button>
      </form>
    </div>

    {{-- Kolom kanan: Kalender mirror --}}
    <div class="col-12 col-lg-6">
        <div class ="pt-3">
      <div class="mb-2 d-flex justify-content-between align-items-center">
        <h5 class="mb-1 "></h5>
        <small class="text-muted">Booked = terisi</small>
      </div>
      </div>

      @include('partials.mirrorCalendar')
    </div>

  </div>
</div>

@endsection
