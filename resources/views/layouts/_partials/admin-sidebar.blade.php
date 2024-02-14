<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
               <x-logo></x-logo>
            </span>
            <span class="logo-lg">
               <x-logo/>
                {{-- <h3 class="mt-3 mb-3"><i class="bx bx-shopping-bag"></i> Edge POS</h3> --}}
            </span>
            <span class="logo-sm">
                <h3><i class="bx bx-menu"></i></h3>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">

            <span class="logo-sm">
                <h3><i class="bx bx-menu"></i></h3>
            </span>
            <span class="logo-lg">
             <x-logo></x-logo>
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>

            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="mdi mdi-view-dashboard"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.packages.index') }}">
                        <i class="mdi mdi-package-variant-closed"></i> <span data-key="t-Packages">Packages</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.bookings.index') }}">
                        <i class="ri-calendar-event-line"></i> <span data-key="t-bookings">Bookings</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.banks.index') }}">
                        <i class="ri-bank-card-fill"></i> <span data-key="t-banks">Banks</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.users.index') }}">
                        <i class="mdi mdi-account-group"></i> <span data-key="t-users">Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.payments.index') }}">
                        <i class="ri-money-dollar-circle-fill"></i> <span data-key="t-payments">Payments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.settings.index')}}">
                        <i class="mdi mdi-cog"></i> <span data-key="t-settings">Settings</span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
