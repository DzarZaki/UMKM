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
        .fc-event.status-new { background:#e2e6ea;color:#212529 }
        .fc-event.status-pending { background:#f6c23e;color:#212529 }
        .fc-event.status-in_progress { background:#36b9cc;color:#fff }
        .fc-event.status-done { background:#1cc88a;color:#fff }
    </style>
</head>

<body id="page-top" class="sidebar-toggled">
<div id="wrapper">

    @include('partials.sidebar-dash')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.topbar-dash')

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        @include('partials.footer-dash')
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('partials.logout-modal')

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
/**
 * ✅ FOTOGRAFER DARI USERS (FINAL & AMAN)
 * Blade tidak boleh pakai `use`
 */
$listFotografer = \App\Models\User::whereIn('role', [
    'fotografer',
    'videografer',
    'fotografer_videografer'
])->orderBy('username')->get();
@endphp

<div class="modal fade" id="exportReportModal" tabindex="-1">
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

                {{-- FOTOGRAFER (USERS) --}}
                <div class="form-group">
                    <label>Fotografer</label>
                    <select name="user_id" class="form-control">
                        <option value="">All</option>
                        @foreach($listFotografer as $f)
                            <option value="{{ $f->id }}">
                                {{ $f->username }} - {{ ucfirst(str_replace('_',' ', $f->role)) }}
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
