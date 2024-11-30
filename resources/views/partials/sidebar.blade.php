<aside>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark shadow accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            {{-- <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div> --}}

            <div class="sidebar-brand-icon">
                <img src="{{ asset('images/logo_it_cyber.png') }}" width="100" alt="">
            </div>
        </a>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Main Menu</div>

        <li class="nav-item @if($_SERVER['REQUEST_URI'] == '/') active @endif">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
            <li class="nav-item @if($_SERVER['REQUEST_URI'] == '/list-employee') active @endif">
                <a class="nav-link" href="{{ route('list-employee') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Anggota</span>
                </a>
            </li>
        @endif

        @if (Auth::user()->role == 'user')
            <li class="nav-item @if($_SERVER['REQUEST_URI'] == '/customers') active @endif">
                <a class="nav-link" href="{{ route('technician.getCustomer') }}">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Tugas</span>
                </a>
            </li>
        @else

            <li class="nav-item @if($_SERVER['REQUEST_URI'] == '/list-customer') active @endif">
                <a class="nav-link" href="{{ route('customer.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Customer</span>
                </a>
            </li>

        @endif

        {{-- <hr class="sidebar-divider d-none d-md-block">

        <div class="sidebar-heading">Report</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('report.technician') }}">
                <i class="fas fa-fw fa-flag"></i>
                <span>Report teknisi</span>
            </a>
        </li> --}}

        <hr class="sidebar-divider d-none d-md-block">

        <div class="sidebar-heading">Setting</div>

        <li class="nav-item">
            <a class="nav-link logoutBtn" href="#">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </li>

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
</aside>