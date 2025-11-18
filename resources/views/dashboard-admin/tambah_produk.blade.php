<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Tambah Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* SALIN SEMUA CSS DARI DASHBOARD.BLADE.PHP ANDA DI SINI */
    /* Pastikan semua style .sidebar, .navbar, .content disalin */

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

    .sidebar .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
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
      transition: all 0.2s;
    }

    .sidebar.collapsed {
      transform: translateX(-200%);
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
      position: fixed;
      top: 0;
      left: 260px;
      width: calc(100% - 260px);
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .navbar.collapsed {
      left: 80px;
      width: calc(100% - 80px);
    }

    /* CONTENT */
    .content {
      margin-left: 260px;
      padding: 100px 30px 30px;
      /* biar gak ketimpa navbar */
      transition: all 0.3s ease;
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

    .form-control:focus {
      border-color: #d1b673;
      box-shadow: 0 0 0 0.25rem rgba(209, 182, 115, 0.4);
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
        <hr class="my-2">
        <p class="nav-section-title">Dashboard</p>
        <a href="/admin/dashboard" class="nav-link active"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Pesanan</p>
        <a href="#" class="nav-link"><i class="bi bi-cart4"></i> <span>Pemesanan Online</span></a>
        <a href="#" class="nav-link"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Produk</p>
        <a href="/tambah_produk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Tambah Produk</span></a>
        <a href="/tambah_produk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Edit Produk</span></a>
        <a href="#" class="nav-link"><i class="bi bi-box-seam"></i> <span>Hapus Produk</span></a>


        <hr class="my-2">
      </div>
    </div>

    <div class="text-center mb-3">
      <a href="/login" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Admin Dashboard">
  </nav>

  <div class="content" id="content">
    <h1 class="h3 fw-bold mb-4">Tambah Produk Baru</h1>

    <div class="card p-4">
      {{-- Form akan dikirimkan ke controller untuk menyimpan produk --}}
      <form action="/admin/produk" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

          {{-- Nama Produk --}}
          <div class="col-md-6">
            <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
          </div>

          {{-- Harga --}}
          <div class="col-md-6">
            <label for="harga" class="form-label fw-bold">Harga (Rp)</label>
            <input type="number" class="form-control" id="harga" name="harga" required min="0">
          </div>

          {{-- Stok --}}
          <div class="col-md-6">
            <label for="stok" class="form-label fw-bold">Stok Tersedia</label>
            <input type="number" class="form-control" id="stok" name="stok" required min="0">
          </div>

          {{-- Pilihan Jenis (Comma Separated) --}}
          <div class="col-md-12">
            <label for="pilihan_jenis" class="form-label fw-bold">Pilihan Jenis (Contoh: Original, Durian,
              Coklat)</label>
            <input type="text" class="form-control" id="pilihan_jenis" name="pilihan_jenis"
              placeholder="Pisahkan dengan koma">
          </div>

          {{-- Deskripsi Produk --}}
          <div class="col-md-12">
            <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi Produk</label>
            <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="5" required></textarea>
          </div>

          {{-- Gambar Produk --}}
          <div class="col-md-12">
            <label for="gambar" class="form-label fw-bold">Gambar Produk</label>
            <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
          </div>

          {{-- Tombol Submit --}}
          <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark fw-bold w-100">
              <i class="bi bi-plus-circle me-2"></i> Simpan Produk Baru
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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