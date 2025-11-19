@extends('templates.sidebar-admin')

@section('title', 'Dashboard Admin')

@section('content')
  <!-- MAIN CONTENT -->
  <div class="content" id="content">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-bag-fill fs-2 text-dark"></i>
          <h6 class="mt-2 text-muted">Produk</h6>
          <h3 class="fw-bold">281</h3>
          <small class="text-success">+55% than last week</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-bar-chart-fill fs-2 text-danger"></i>
          <h6 class="mt-2 text-muted">Data Users</h6>
          <h3 class="fw-bold">2,300</h3>
          <small class="text-success">+3% than last week</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-basket-fill fs-2 text-success"></i>
          <h6 class="mt-2 text-muted">Pemesanan</h6>
          <h3 class="fw-bold">34k</h3>
          <small class="text-success">+1% than yesterday</small>
        </div>
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      navbar.classList.toggle('collapsed');
      content.classList.toggle('collapsed');
    });
  </script>

@endsection
