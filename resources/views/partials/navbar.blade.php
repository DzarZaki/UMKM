<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-modern">
    <div class="container">

        {{-- BRAND / LOGO --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-dzar.png') }}"
                 alt="DZAR Logo"
                 class="navbar-logo">
        </a>

        {{-- MOBILE TOGGLE --}}
        <button class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- NAVBAR MENU --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-lg-2">

                {{-- PORTFOLIO DROPDOWN --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="portfolioDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        PORTFOLIO
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark border-0 bg-dark shadow">

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('portfolio.prewedding') }}">
                                Prewedding
                            </a>
                        </li>

                        <li><hr class="dropdown-divider border-secondary"></li>

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('portfolio.wedding') }}">
                                Wedding
                            </a>
                        </li>

                        <li><hr class="dropdown-divider border-secondary"></li>

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('portfolio.wisuda') }}">
                                Wisuda
                            </a>
                        </li>

                        <li><hr class="dropdown-divider border-secondary"></li>

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('portfolio.lamaran') }}">
                                Lamaran
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- PRICELIST --}}
                <li class="nav-item">
                    <a class="nav-link"
                       href="https://drive.google.com/file/d/18_nfvGHXI-E4hhz19Y9fEqP8pEyh1Bnn/view"
                       target="_blank"
                       rel="noopener noreferrer">
                        PRICELIST
                    </a>
                </li>

                {{-- BOOKING BUTTON --}}
                <li class="nav-item">
                    <a class="btn btn-booking ms-lg-3"
                       href="{{ url('booking') }}">
                        BOOKING
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
