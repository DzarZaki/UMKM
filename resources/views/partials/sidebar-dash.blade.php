<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-camera-retro"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Dzar<sup>Project</sup>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Reservasi -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('reservasi.index') }}">
    <i class="fas fa-calendar"></i>
    <span>Booking</span>
        </a>
    </li>

    <!-- Nav Item - Galeri -->
    <li class="nav-item {{ request()->routeIs('galeri.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('galeri.index') }}">
            <i class="fas fa-images"></i>
            <span>Galeri</span>
        </a>
    </li>

    <!-- Nav Item - Tables (placeholder) -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
    </li>

    <!-- Nav Item - Fotografer (placeholder) -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users"></i>
            <span>Fotografer</span>
        </a>
    </li>

    <!-- Nav Item - Extra Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Extra Menu</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
