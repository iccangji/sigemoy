<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="">Tenggara<span class="text-warning">.</span></a> 
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">T.</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="dropdown {{ Request::is('Admin-Dashboard') ?  'active' : '' }}">
          <a href="#" class="nav-link has-dropdown "><i class="fas fa-home"></i><span>Dashboard</span></a>
          <ul class="dropdown-menu">
            <li class={{ Request::is('Admin-Dashboard') ?  'active' : '' }}>
                <a class="nav-link" href="/Admin-Dashboard">Dashboard</a>
            </li>
          </ul>
        </li>
        <li class="menu-header">Halaman</li>
        <li class="{{ Request::is('Data-Pemilih') ?  'active' : '' }}"><a class="nav-link" href="/Data-Pemilih"><i class="fa-solid fa-user-check"></i> <span>Data Pemilih</span></a></li>     
    </aside>
  </div>