<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-modern">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="{{ url('/') }}">DZAR</a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">

                <!-- Portfolio Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">
                        PORTFOLIO
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark border-0 bg-dark">
                        <li>
                            <a class="dropdown-item" href="{{ route('portfolio.prewedding') }}">
                                Prewedding
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider border-secondary">
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('portfolio.wedding') }}">
                                Wedding
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pricelist (Google Drive Viewer - STABLE) -->
                <li class="nav-item">
                    <a class="nav-link"
                       href="https://drive.google.com/file/d/18_nfvGHXI-E4hhz19Y9fEqP8pEyh1Bnn/view"
                       target="_blank"
                       rel="noopener">
                        PRICELIST
                    </a>
                </li>

                <!-- Booking Button -->
                <li class="nav-item">
                    <a class="btn btn-booking ms-3" href="{{ url('booking') }}">
                        BOOKING
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
