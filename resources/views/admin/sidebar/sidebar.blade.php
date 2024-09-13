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
                <a class="nav-link" href="{{ route('Admin-Dashboard') }}">Dashboard</a>
            </li>
          </ul>
        </li>
        <li class="menu-header">Pages</li>
        {{-- <li class="dropdown {{ Request::is('DestinasiWisata') ?  'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-map-marker-alt"></i> <span>Informasi Destinasi</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('DestinasiWisata') ?  'active' : '' }}"><a class="nav-link" href="{{ route('DestinasiWisata') }}">Destinasi Wisata</a></li>
          </ul>
        </li>
        <li class="dropdown {{ Request::is('Akomodasi') ?  'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-dollar-sign"></i> <span>Informasi Transportasi</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('Akomodasi') ?  'active' : '' }}"><a class="nav-link" href="{{ route('Akomodasi') }}">Transportasi</a></li>
          </ul>
        </li>
        <li class="dropdown {{ Request::is('Event') ?  'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-calendar-plus"></i> <span>Informasi Event</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('Event') ?  'active' : '' }}"><a class="nav-link" href="{{ route('Event') }}">Event</a></li>
          </ul>
        </li>
        <li class="dropdown {{ Request::is('kelolauser') ?  'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i> <span>Informasi User</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('kelolauser') ?  'active' : '' }}"><a class="nav-link" href="{{ route('kelolauser') }}">Kelola User</a></li>
          </ul>
        </li>
        <li class="dropdown {{ Request::is('InformasiReview') ?  'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-star-half-alt"></i> <span>Informasi Review</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('InformasiReview') ?  'active' : '' }}"><a class="nav-link" href="{{ route('review') }}">Review</a></li>
          </ul>
        </li> --}}
        <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
        
      
        
        
             
    </aside>
  </div>