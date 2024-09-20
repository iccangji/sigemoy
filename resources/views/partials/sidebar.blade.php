<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">SIGEMOY<span class="text-warning">.</span></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Halaman</li>
            @if ($level == 'admin')
                <li class=" {{ $page == 'dashboard' ? 'active' : '' }}">
                    <a href="/" class="nav-link "><i class="fa-solid fa-home"></i><span>Dashboard</span></a>
                </li>

                <li class="{{ $page == 'pemilih' ? 'active' : '' }}">
                    <a class="nav-link" href="/pemilih"><i class="fa-solid fa-list"></i><span>Data Pemilih</span></a>
                </li>
                <li class="{{ Request::is('data-ganda') ? 'active' : '' }}">
                    <a class="nav-link" href="/data-ganda"><i class="fa-solid fa-copy"></i><span>Data Ganda</span></a>
                </li>
                <li class="{{ Request::is('data-invalid') ? 'active' : '' }}">
                    <a class="nav-link" href="/data-invalid"><i class="fa-solid fa-user-xmark"></i><span>Data Tidak
                            Valid</span></a>
                </li>
                <li class="{{ $page == 'data-kpu' ? 'active' : '' }}">
                    <a class="nav-link" href="/data-kpu"><i class="fa-solid fa-user-check"></i><span>Data KPU</span></a>
                </li>
                <li class="{{ Request::is('penanggung-jawab') ? 'active' : '' }}">
                    <a class="nav-link" href="/penanggung-jawab"><i class="fa-solid fa-users"></i><span>Data Penanggung
                            Jawab</span></a>
                </li>
                <li class="{{ Request::is('data-user') ? 'active' : '' }}">
                    <a class="nav-link" href="/data-user"><i class="fa-solid fa-user"></i><span>Data User </span></a>
                </li>
            @elseif ($level == 'penginput')
                <li class="{{ Request::is('pemilih') ? 'active' : '' }}">
                    <a class="nav-link" href="/pemilih"><i class="fa-solid fa-list"></i><span>Data Pemilih</span></a>
                </li>
                <li class="{{ Request::is('penanggung-jawab') ? 'active' : '' }}">
                    <a class="nav-link" href="/penanggung-jawab"><i class="fa-solid fa-users"></i><span>Data Penanggung
                            Jawab</span></a>
                </li>
            @else
                <li class=" {{ $page == 'dashboard' ? 'active' : '' }}">
                    <a href="/" class="nav-link "><i class="fa-solid fa-home"></i><span>Dashboard</span></a>
                </li>

                <li class="{{ $page == 'pemilih' ? 'active' : '' }}">
                    <a class="nav-link" href="/pemilih"><i class="fa-solid fa-list"></i><span>Data Pemilih</span></a>
                </li>
                <li class="{{ Request::is('data-ganda') ? 'active' : '' }}">
                    <a class="nav-link" href="/data-ganda"><i class="fa-solid fa-copy"></i><span>Data Ganda</span></a>
                </li>
                <li class="{{ Request::is('data-invalid') ? 'active' : '' }}">
                    <a class="nav-link" href="/data-invalid"><i class="fa-solid fa-user-xmark"></i><span>Data Tidak
                            Valid</span></a>
                </li>
                <li class="{{ $page == 'data-kpu' ? 'active' : '' }}">
                    <a class="nav-link" href="/data-kpu"><i class="fa-solid fa-user-check"></i><span>Data KPU</span></a>
                </li>
                <li class="{{ Request::is('penanggung-jawab') ? 'active' : '' }}">
                    <a class="nav-link" href="/penanggung-jawab"><i class="fa-solid fa-users"></i><span>Data Penanggung
                            Jawab</span></a>
                </li>
            @endif

        </ul>
    </aside>
</div>
