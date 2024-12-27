<header id="header" class="header sticky-top">

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Kel Bengkel</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('pasien.dashboard') }}">Dashboard</a></li>
                    <li>
                        <a href="{{ route('pasien.poli') }}">
                            Daftar Poli
                        </a>
                    </li>
                    <li class="dropdown "><a href="#"><span>Dashboard</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li>
                                <a href="{{ route('pasien.profile') }}">Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('pasien.riwayat') }}">Riwayat</a>
                            </li>
                            <li>
                                <form action="{{ route('pasien.logout') }}" method="POST" class="px-3">
                                    @csrf
                                    <button class="btn btn-danger btn-block  w-100 text-start"
                                        type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>

    </div>

</header>
