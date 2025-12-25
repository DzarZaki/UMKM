<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/galeri-admin.css') }}" rel="stylesheet"> -->

    <!-- FullCalendar (BENAR) -->
    <link rel="stylesheet" href="https://unpkg.com/fullcalendar@6.1.11/index.global.min.css"> 
    <script src="https://unpkg.com/fullcalendar@6.1.11/index.global.min.js"></script>

    <style>
/* ===============================
   FULLCALENDAR STATUS COLORS
   =============================== */

/* NEW */
.fc-event.status-new {
  background-color: #e2e6ea !important;
  border-color: #e2e6ea !important;
  color: #212529 !important;
}

/* PENDING */
.fc-event.status-pending {
  background-color: #f6c23e !important;
  border-color: #f6c23e !important;
  color: #212529 !important;
}

/* IN PROGRESS */
.fc-event.status-in_progress {
  background-color: #36b9cc !important;
  border-color: #36b9cc !important;
  color: #ffffff !important;
}

/* DONE */
.fc-event.status-done {
  background-color: #1cc88a !important;
  border-color: #1cc88a !important;
  color: #ffffff !important;
}

/* hover */
.fc-event:hover {
  filter: brightness(0.95);
}
</style>

</head>

<body id="page-top">

<div id="wrapper">

    {{-- Sidebar --}}
    @include('partials.sidebar-dash')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            {{-- Topbar --}}
            @include('partials.topbar-dash')

            {{-- Page Content --}}
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

        {{-- Footer --}}
        @include('partials.footer-dash')
    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('partials.logout-modal')

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script> -->
@stack('scripts')

</body>
</html>
