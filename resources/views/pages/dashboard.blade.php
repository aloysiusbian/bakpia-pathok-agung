<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fbf3df;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* SIDEBAR */
    .sidebar {
      width: 260px;
      background-color: #e3d3ad;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
      padding: 10px 0;
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .sidebar .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 15px;
    }

    .sidebar .logo img {
      align-self;: center
    }

    .sidebar .logo h5 {
      margin: 0;
      font-weight: 700;
      color: #3a2d1a;
    }

    .sidebar .profile {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar .profile img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
    }

    .sidebar .profile h6 {
      margin-top: 8px;
      font-weight: 600;
      color: #3a2d1a;
    }

    .nav-section-title {
      font-size: 0.8rem;
      font-weight: 600;
      color: #6e5b3b;
      margin: 10px 20px 5px;
    }

    .sidebar .nav-link {
      color: #3a2d1a;
      border-radius: 8px;
      margin: 4px 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      transition: all 0.2s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #d1b673;
      color: #000;
      font-weight: 600;
    }

    .offline-btn {
      margin: 15px 20px;
      border-radius: 10px;
      background-color: white;
      color: #3a2d1a;
      font-weight: 600;
    }

    .offline-btn i {
      margin-right: 5px;
    }

    /* NAVBAR */
    .navbar {
      background-color: #f5c24c;
      padding: 10px 25px;
      margin-left: 260px;
      transition: all 0.3s;
    }

    .navbar.collapsed {
      margin-left: 80px;
    }

    .navbar input {
      border-radius: 25px;
      border: none;
      padding-left: 20px;
    }

    /* CONTENT */
    .content {
      margin-left: 260px;
      padding: 30px;
      transition: all 0.3s;
    }

    .content.collapsed {
      margin-left: 80px;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .card i {
      display: inline-block;
      margin-bottom: 10px;
      border-radius: 10px;
      padding: 10px;
    }

    .card small {
      font-size: 0.85rem;
    }
  </style>
</head>

<body>

  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div>
      <a class="logo" href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">
      </a>
      <div class="profile">
        <img src="{{ asset('images/bian.png') }}" alt="Admin">
        <h6>Alberto Sahara</h6>
      </div>

      <div class="menu px-2">
        <p class="nav-section-title">Dashboard</p>
        <a href="/admin/dashboard" class="nav-link active"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>

        <p class="nav-section-title mt-3">Pages</p>
        <a href="#" class="nav-link"><i class="bi bi-cart4"></i> <span>Pemesanan</span></a>
        <a href="#" class="nav-link"><i class="bi bi-people-fill"></i> <span>Data Users</span></a>
        <a href="/tambah_produk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Tambah Produk</span></a>
      </div>
    </div>

    <div class="text-center mb-3">
      <button class="btn offline-btn w-75"><i class="bi bi-telephone"></i> Pemesanan Offline</button>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Admin Dashboard">
    <i class="bi bi-person-circle fs-4"></i>
  </nav>

  <!-- MAIN CONTENT -->
  <div class="content" id="content">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-bag-fill fs-2 text-dark bg-light"></i>
          <h6 class="mt-2 text-muted">Produk</h6>
          <h3 class="fw-bold">281</h3>
          <small class="text-success">+55% than last week</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-bar-chart-fill fs-2 text-danger bg-light"></i>
          <h6 class="mt-2 text-muted">Data Users</h6>
          <h3 class="fw-bold">2,300</h3>
          <small class="text-success">+3% than last week</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-basket-fill fs-2 text-success bg-light"></i>
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
</body>

</html>