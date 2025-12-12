<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-modern">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">DZAR</a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        PORTFOLIO
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark border-0 bg-dark">
                        <li><a class="dropdown-item" href="#prewedding">Prewedding</a></li>
                        <li><hr class="dropdown-divider border-secondary"></li>
                        <li><a class="dropdown-item" href="#wedding">Wedding</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ asset('PL PREWED & WEDDING DZAR PROJECT 2025.pdf') }}" download>PRICELIST</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-booking ms-3" href="{{ url('booking') }}">BOOKING</a>
                </li>
            </ul>
        </div>
    </div>
</nav>