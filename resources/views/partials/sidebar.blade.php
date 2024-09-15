<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="">SIGEMOY<span class="text-warning">.</span></a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Halaman</li>
    
        <li class=" {{ $page=='dashboard' ?  'active' : '' }}">
          <a href="/" class="nav-link "><i class="fa-solid fa-home"></i><span>Dashboard</span></a>
        </li>
      
      <li class="{{ Request::is('Data-Pemilih') ?  'active' : '' }}">
        <a class="nav-link" href="/Data-Pemilih"><i class="fa-solid fa-user-check"></i><span>Data Pemilih</span></a>
      </li>
    </ul>
  </aside>
</div>