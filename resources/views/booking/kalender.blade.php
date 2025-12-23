<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kalender Booking</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

  <style>
    body { font-family: system-ui, Arial, sans-serif; margin: 16px; }
    #calendar { max-width: 1100px; margin-top: 12px; }
    .hint { margin: 8px 0 14px; }
  </style>
</head>
<body>
  <h2>Cek Jadwal</h2>
  <div class="hint">
    <strong>Booked</strong> = sudah terisi. <strong>Slot kosong</strong> = available.
  </div>

  <div id="calendar"></div>



  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,'
        },

        initialView: 'dayGridMonth',
        nowIndicator: true,

        // Biar fokus ke jam (karena kamu punya waktu_mulai & waktu_selesai)
        allDaySlot: false,
        slotMinTime: '07:00:00', // sesuaikan jam operasional
        slotMaxTime: '21:00:00',

        // Ambil event booked dari backend
        events: "{{ route('booking.kalender.events') }}",

        // KUNCI VIEW-ONLY
        editable: false,
        selectable: false,
        eventStartEditable: false,
        eventDurationEditable: false,
        droppable: false,

        // Optional: klik event cuma kasih info (tidak ada edit)
        // eventClick: function(info) {
        //   info.jsEvent.preventDefault();
        //   alert('Slot ini sudah BOOKED.');
        // },
      });

      calendar.render();
    });
  </script>
</body>
</html>
