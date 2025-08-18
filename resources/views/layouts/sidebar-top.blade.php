<div class="sidebar p-4">
  <h4 class="text-white" style="text-align: center">Admin</h4>
  <a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
  <a href="{{ route('admin.order') }}"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
    <div class="dropdown">
    <a class="dropdown-toggle d-block text-white" href="#" id="dropdownRooms" data-bs-toggle="collapse" data-bs-target="#collapseRooms" aria-expanded="false">
      <i class="fas fa-door-open me-2"></i> Rooms
    </a>
    <div class="collapse ms-3" id="collapseRooms">
      <a class="d-block text-white" href="{{ route('admin.tipekamar') }}">Tipe Kamar</a>
      <a class="d-block text-white" href="{{ route('admin.kamardalam') }}">Nama Kamar</a>
    </div>
      <a href="{{ route('admin.pemesanan') }}"><i class="fas fa-bed me-2"></i> Pesan</a>
  </div>
<a href="{{ route('logout') }}" class="logout-link"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   <i class="fas fa-sign-out-alt me-2"></i> Logout
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
</div>

<div class="topbar d-flex justify-content-between align-items-center">
  <h5 class="mb-0 fw-bold"></h5>
  <span class="text-muted">{{ Auth::user()->name }}</span>
</div>
