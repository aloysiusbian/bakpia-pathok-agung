<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pemesanan Offline | Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #fbf3df;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

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
      z-index: 1030;
    }

    .sidebar.collapsed {
      transform: translateX(-200%);
    }

    .sidebar .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
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
      left: 0;
      width: 100%;
    }

    .content {
      margin-left: 260px;
      padding: 100px 30px 30px;
      transition: all 0.3s ease;
    }

    .content.collapsed {
      margin-left: 0;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header-custom {
      background: linear-gradient(135deg, #ffe2a4, #f5c24c);
      border-radius: 12px 12px 0 0;
      border-bottom: none;
      color: #4a3312;
    }

    .section-title {
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      color: #7b643c;
      margin-bottom: 4px;
    }

    .form-label {
      font-size: 0.85rem;
      font-weight: 500;
      color: #4b3920;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
      border-color: #e0c78b;
      font-size: 0.9rem;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #f0b232;
      box-shadow: 0 0 0 0.15rem rgba(240, 178, 50, 0.35);
    }

    .btn-theme {
      background-color: #f5c24c;
      border-color: #f5c24c;
      color: #4a3312;
      font-weight: 600;
      border-radius: 999px;
      padding: 8px 22px;
    }

    .btn-theme:hover {
      background-color: #e8b138;
      border-color: #e8b138;
      color: #3a2d1a;
    }

    .btn-outline-theme {
      border-radius: 999px;
      border-color: #f5c24c;
      color: #4a3312;
      font-weight: 500;
    }

    .btn-outline-theme:hover {
      background-color: #f5c24c;
      color: #3a2d1a;
    }

    .order-type-badge {
      font-size: 0.8rem;
      border-radius: 999px;
      padding: 4px 10px;
      background-color: #fff3cd;
      color: #7b643c;
    }

    .produk-row {
      background-color: #fff7e5;
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 10px;
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
        <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Pesanan</p>
        <a href="{{ route('admin.pemesanan.online') }}" class="nav-link"><i class="bi bi-cart4"></i> <span>Pemesanan Online</span></a>


        <a href="{{ route('admin.pemesanan.offline') }}" class="nav-link active"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Produk</p>
        <a href="/lihatproduk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Lihat Produk</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Admin</p>
        <a href="/testambahakun" class="nav-link"><i class="bi bi-person-fill-add"></i> <span>Tambah Akun Admin</span></a>        
        <a href="/teskelolaadmin" class="nav-link"><i class="bi bi-people-fill"></i> <span>Kelola Akun</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Admin</p>
        <a href="/teskelolaadmin" class="nav-link"><i class="bi bi-people-fill"></i> <span>Kelola Akun Admin</span></a>
        <a href="/testambahakun" class="nav-link"><i class="bi bi-person-fill-add"></i> <span>Tambah Akun Admin</span></a>
        <hr class="my-2">
      </div>
    </div>

    <div class="text-center mb-3">
      <a href="/"class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i>Logout</a>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <span class="fw-semibold">Tambah Pemesanan Offline</span>
  </nav>

  <!-- CONTENT -->
  <main class="content" id="content">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h4 class="mb-0">Form Pemesanan Offline</h4>
          <small class="text-muted">
            Digunakan untuk mencatat pesanan yang masuk via telepon, WhatsApp, atau pelanggan datang langsung ke toko.
          </small>
        </div>
        <a href="#" class="btn btn-outline-theme btn-sm">
          <i class="bi bi-arrow-left"></i> Kembali ke daftar
        </a>
      </div>

      <div class="card">
        <div class="card-header card-header-custom">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="section-title mb-1">Detail Pemesanan</div>
              <div class="fw-semibold">Input Pesanan Offline</div>
              <span class="order-type-badge mt-1 d-inline-block">
                <i class="bi bi-telephone-inbound"></i> Offline (Telepon / Datang Langsung)
              </span>
            </div>
            <i class="bi bi-clipboard-plus fs-2 opacity-75"></i>
          </div>
        </div>

        <div class="card-body">

          <!-- FORM PEMESANAN OFFLINE (TANPA LOGIC) -->
          <form action="#" method="POST">
            <!-- DATA PELANGGAN -->
            <div class="mb-3">
              <div class="section-title">Data Pelanggan</div>
              <small class="text-muted">Bisa diisi singkat, cukup untuk identifikasi & kontak.</small>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-5">
                <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Contoh: Budi Santoso">
              </div>
              <div class="col-md-4">
                <label class="form-label">No. HP / WA <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Contoh: 0812-3456-7890">
              </div>
              <div class="col-md-3">
                <label class="form-label">Sumber Pesanan <span class="text-danger">*</span></label>
                <select class="form-select">
                  <option value="">-- Pilih --</option>
                  <option>Telepon</option>
                  <option>WhatsApp</option>
                  <option>Datang Langsung</option>
                  
                </select>
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-8">
                <label class="form-label">Alamat (opsional)</label>
                <textarea rows="2" class="form-control" placeholder="Isi jika pesanan dikirim ke alamat pelanggan"></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label">Catatan (opsional)</label>
                <textarea rows="2" class="form-control" placeholder="Contoh: Pelanggan langganan, minta lebih matang, dsb"></textarea>
              </div>
            </div>

            <hr>

            <!-- DETAIL PRODUK -->
            <div class="mb-3">
              <div class="section-title">Detail Produk Pesanan</div>
              <small class="text-muted">Pilih produk dan jumlah yang dipesan.</small>
            </div>

            <div id="produkWrapper" class="mb-3">
              <div class="produk-row row g-2 align-items-end">
                <div class="col-md-5">
                  <label class="form-label mb-1">Produk</label>
                  <select class="form-select">
                    <option value="">-- Pilih Produk --</option>
                    <option>Bakpia Kacang Hijau (Stok: 50)</option>
                    <option>Bakpia Coklat (Stok: 30)</option>
                    <option>Bakpia Keju (Stok: 20)</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label mb-1">Jumlah</label>
                  <input type="number" min="1" class="form-control" value="1">
                </div>
                <div class="col-md-3">
                  <label class="form-label mb-1">Harga Satuan (Rp)</label>
                  <input type="number" min="0" class="form-control" placeholder="Contoh: 35000">
                </div>
                <div class="col-md-2 text-md-end">
                  <button type="button" class="btn btn-outline-theme btn-sm mt-1" id="btnTambahProduk">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                  </button>
                </div>
              </div>
            </div>

            <!-- INFORMASI TRANSAKSI -->
            <div class="mb-3">
              <div class="section-title">Informasi Transaksi</div>
              <small class="text-muted">Atur tanggal, metode, dan status pembayaran.</small>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-3">
                <label class="form-label">Tanggal Pesan <span class="text-danger">*</span></label>
                <input type="date" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Tanggal Ambil / Kirim</label>
                <input type="date" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                <select class="form-select">
                  <option value="">-- Pilih Metode --</option>
                  <option>Tunai</option>
                  <option>Transfer Bank</option>
                  <option>QRIS</option>
                  
                </select>
              </div>

            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label class="form-label">Total Tagihan (Rp)</label>
                <input type="number" min="0" class="form-control" placeholder="Contoh: 250000">
              </div>
              <div class="col-md-4">
                <label class="form-label">Uang Diterima (Rp)</label>
                <input type="number" min="0" class="form-control" placeholder="Isi jika sudah bayar/DP">
              </div>
              <div class="col-md-4">
                <label class="form-label">Nama Kasir / Admin</label>
                <input type="text" class="form-control" placeholder="Contoh: Berto">
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <small class="text-muted">
                <i class="bi bi-info-circle"></i>
                Pesanan ini akan tampil di menu <strong>Pemesanan Offline</strong> pada dashboard (secara konsep).
              </small>
              <div class="d-flex gap-2">
                <button type="reset" class="btn btn-outline-secondary btn-sm">
                  Reset
                </button>
                <button type="submit" class="btn btn-theme btn-sm">
                  <i class="bi bi-save"></i> Simpan Pesanan
                </button>
              </div>
            </div>

          </form>

        </div>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      navbar.classList.toggle('collapsed');
      content.classList.toggle('collapsed');
    });

    // Tambah baris produk dinamis (front-end saja, tanpa logic backend)
    const btnTambahProduk = document.getElementById('btnTambahProduk');
    const produkWrapper = document.getElementById('produkWrapper');
    let produkIndex = 1;

    btnTambahProduk.addEventListener('click', () => {
      const row = document.createElement('div');
      row.classList.add('produk-row', 'row', 'g-2', 'align-items-end');

      row.innerHTML = `
        <div class="col-md-5">
          <label class="form-label mb-1">Produk</label>
          <select class="form-select">
            <option value="">-- Pilih Produk --</option>
            <option>Bakpia Kacang Hijau (Stok: 50)</option>
            <option>Bakpia Coklat (Stok: 30)</option>
            <option>Bakpia Keju (Stok: 20)</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label mb-1">Jumlah</label>
          <input type="number" min="1" class="form-control" value="1">
        </div>
        <div class="col-md-3">
          <label class="form-label mb-1">Harga Satuan (Rp)</label>
          <input type="number" min="0" class="form-control">
        </div>
        <div class="col-md-2 text-md-end">
          <button type="button" class="btn btn-outline-danger btn-sm btnHapusProduk">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      `;

      produkWrapper.appendChild(row);
      produkIndex++;

      row.querySelector('.btnHapusProduk').addEventListener('click', () => {
        row.remove();
      });
    });
  </script>
</body>

</html>
