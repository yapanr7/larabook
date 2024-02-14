<nav class="navbar navbar-expand-lg navbar-white" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home')}}">
            <x-logo></x-logo>
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-purple fw-bold fs-14" href="{{ route('home')}}"><span class="text-purple">Home</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-purple fw-bold fs-14" href="{{ route('packages.index') }}">Packages</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-purple fw-bold fs-14" href="{{ route('bookings.index') }}">Booking</a>
                </li>
               
            </ul>
            @auth
            <div class="d-flex user-logged nav-item dropdown no-arrow">
                <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Halo, {{ auth()->user()->name }}!
                    {{-- <img src="{{Auth::user()->avatar }}" class="user-photo" alt=""> --}}
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="right: 0; left: auto;">
                        @if (auth()->user()->is_admin)

                        <li>
                            <a href="{{ route('admin.dashboard')}}" class="dropdown-item">My Dashboard</a>
                        </li>
                        @endif
                        
                        <li><a class="dropdown-item" href="{{ route('logout')}}">Logout</a></li>

                    </ul>
                </a>
            </div>
            @else
                <div class="d-flex">
                    <a href="{{ route('login')}}" class="btn btn-master btn-secondary me-3">
                        Sign In
                    </a>
                    <a href="{{route('register') }}" class="btn btn-master btn-primary">
                        Sign Up
                    </a>
                </div>
            @endauth
           
        </div>
    </div>
</nav>
