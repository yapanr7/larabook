<nav class="navbar navbar-expand-lg bg-custom fixed-top" id="navbar">
    <div class="container custom-container">
        <a class="navbar-brand" href="{{ route('home')}}">
            <x-logo></x-logo>
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mt-2 mt-lg-0" id="navbar-example">

                <li class="nav-item">
                    <a class="nav-link text-white fw-bold fs-14" href="{{ route('packages.index') }}">Paket Foto</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-bold fs-14" href="{{ route('bookings.index') }}">Booking</a>
                </li>

            </ul>

            <div class="ms-auto">
                @guest

                <a href="{{ route('login')}}" class="btn btn-light w-100"><i class="ri-user-3-line align-bottom me-1"></i> Login & Register</a>
                @endguest

                @auth

                <div class="dropdown">
                    <button class="btn btn-dark w-100 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                        @if (auth()->user()->is_admin)

                        <li><a class="dropdown-item" href="{{ route('admin.dashboard')}}">Admin Panel</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('logout')}}">Logout</a></li>
                    </ul>
                </div>
                @endauth

            </div>
        </div>

    </div>
</nav>
