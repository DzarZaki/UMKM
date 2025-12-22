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
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      initialView: 'timeGridWeek',
      nowIndicator: true,
      allDaySlot: false,
      slotMinTime: '07:00:00',
      slotMaxTime: '21:00:00',

      events: "{{ route('booking.kalender.events') }}",

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
