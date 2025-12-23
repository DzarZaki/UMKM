<div class="calendar-wrap">
  <h2></h2>
  <h2>Cek Jadwal</h2>
  <p><b>Booked</b> = sudah terisi. Slot kosong = available.</p>

  <div id="booking-calendar"></div>
</div>

<!-- @once
  @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">
  @endpush

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  @endpush
@endonce -->

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('booking-calendar');
    if (!el) return;

    const calendar = new FullCalendar.Calendar(el, {
      headerToolbar: {
        left: 'prev,today',
        center: 'title',
        right: 'next'
      },
      initialView: 'dayGridMonth',
      nowIndicator: true,
      // events: {
      // url: 'booking/kalender/events',
      // extraParams: function () {
      //   return {
      //     status: document.getElementById('filter_status')?.value || '',
      //     // kalau kamu mau include new via toggle:
      //     // include_new: document.getElementById('include_new')?.checked ? 1 : 0,
      //   };
      // }},
      events: {
      url: "{{ route('booking.kalender.events') }}", // ✅ ini yang bener
      method: 'GET',
    },

      // VIEW ONLY
      editable: false,
      selectable: false,
      eventStartEditable: false,
      eventDurationEditable: false,
      droppable: false,

    //   eventClick: function(info) {
    //     info.jsEvent.preventDefault();
    //     alert('Slot ini sudah BOOKED.');
    //   },
    });

    calendar.render();
  });
</script>
@endpush
