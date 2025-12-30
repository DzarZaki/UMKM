<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ auth()->user()->role === 'admin'
                ? route('dashboard')
                : route('dashboard.fotografer') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-camera-retro"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Dzar<sup>Project</sup>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
        <a class="nav-link"
           href="{{ auth()->user()->role === 'admin'
                ? route('dashboard')
                : route('dashboard.fotografer') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Menu</div>

    {{-- ===================== --}}
    {{-- ADMIN MENU --}}
    {{-- ===================== --}}
    @if(auth()->user()->role === 'admin')

        <!-- Reservasi -->
        <li class="nav-item {{ request()->routeIs('reservasi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('reservasi.index') }}">
                <i class="fas fa-calendar"></i>
                <span>Reservasi</span>
            </a>
        </li>

        <!-- Export -->
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#exportReportModal">
                <i class="fas fa-file-export"></i>
                <span>Export / Report</span>
            </a>
        </li>

        <!-- Galeri -->
        <li class="nav-item {{ request()->routeIs('galeri.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('galeri.index') }}">
                <i class="fas fa-images"></i>
                <span>Galeri</span>
            </a>
        </li>

         @if(auth()->user()->role === 'admin')
<li class="nav-item {{ request()->routeIs('fotografer.*') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('fotografer.index') }}">
    <i class="fas fa-users"></i>
    <span>Fotografer</span>
  </a>
</li>
@endif

    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

   


</ul>
<!-- End Sidebar -->
