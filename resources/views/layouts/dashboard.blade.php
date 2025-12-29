<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- FullCalendar -->
    <link rel="stylesheet" href="https://unpkg.com/fullcalendar@6.1.11/index.global.min.css">
    <script src="https://unpkg.com/fullcalendar@6.1.11/index.global.min.js"></script>

    <style>
        /* FULLCALENDAR STATUS COLORS */
        .fc-event.status-new {
            background-color: #e2e6ea !important;
            border-color: #e2e6ea !important;
            color: #212529 !important;
        }
        .fc-event.status-pending {
            background-color: #f6c23e !important;
            border-color: #f6c23e !important;
            color: #212529 !important;
        }
        .fc-event.status-in_progress {
            background-color: #36b9cc !important;
            border-color: #36b9cc !important;
            color: #ffffff !important;
        }
        .fc-event.status-done {
            background-color: #1cc88a !important;
            border-color: #1cc88a !important;
            color: #ffffff !important;
        }
        .fc-event:hover {
            filter: brightness(0.95);
        }
    </style>
</head>

<body id="page-top" class="sidebar-toggled">


<div id="wrapper">

    {{-- SIDEBAR --}}
    @include('partials.sidebar-dash')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            {{-- TOPBAR --}}
            @include('partials.topbar-dash')

            {{-- PAGE CONTENT --}}
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

        {{-- FOOTER --}}
        @include('partials.footer-dash')
    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('partials.logout-modal')

<!-- JS -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

@stack('scripts')

{{-- ============================= --}}
{{-- MODAL EXPORT / REPORT (ADMIN) --}}
{{-- ============================= --}}
@if(auth()->check() && auth()->user()->role === 'admin')
@php
    // 🔑 AMAN: ambil langsung dari model, tidak tergantung controller
    $listFotografer = \App\Models\Fotografer::orderBy('nama_fotografer')->get();
@endphp

<div class="modal fade" id="exportReportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="GET"
              action="{{ route('reservasi.export.excel') }}"
              class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Export / Report</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- PERIODE --}}
                <div class="form-group">
                    <label>Periode</label>
                    <div class="d-flex">
                        <input type="date" name="start_date" class="form-control mr-2">
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="new">New</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                </div>

                {{-- FOTOGRAFER --}}
                <div class="form-group">
                    <label>Fotografer</label>
                    <select name="id_fotografer" class="form-control">
                        <option value="">All</option>
                        @foreach($listFotografer as $f)
                            <option value="{{ $f->id }}">
                                {{ $f->nama_fotografer }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    Export Excel
                </button>
            </div>

        </form>
    </div>
</div>
@endif

</body>
</html>
