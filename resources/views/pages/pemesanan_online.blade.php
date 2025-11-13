<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemesanan Online | Dashboard</title>
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

    .badge-status {
      font-size: 0.75rem;
      padding: 6px 10px;
      border-radius: 999px;
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
        <a href="/admin/dashboard" class="nav-link">
          <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
        <a href="#" class="nav-link">
          <i class="bi bi-graph-up"></i> <span>Analytics</span>
        </a>

        <hr class="my-2">
        <p class="nav-section-title mt-3">Pesanan</p>
        <a href="/admin/pemesanan-online" class="nav-link active">
          <i class="bi bi-cart4"></i> <span>Pemesanan Online</span>
        </a>
        <a href="#" class="nav-link">
          <i class="bi bi-telephone"></i> <span>Pemesanan Offline</span>
        </a>

        <hr class="my-2">
        <p class="nav-section-title mt-3">Produk</p>
        <a href="/tambah_produk" class="nav-link">
          <i class="bi bi-box-seam"></i> <span>Tambah Produk</span>
        </a>
        <a href="#" class="nav-link">
          <i class="bi bi-pencil-square"></i> <span>Edit Produk</span>
        </a>
        <a href="#" class="nav-link">
          <i class="bi bi-trash3"></i> <span>Hapus Produk</span>
        </a>
        <hr class="my-2">
      </div>
    </div>

    <div class="text-center mb-3">
      <a href="/" class="btn offline-btn w-75">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Cari pesanan...">
    <span class="ms-3 fw-semibold">Pemesanan Online</span>
  </nav>

  <!-- CONTENT -->
  <main class="content" id="content">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h4 class="mb-0">Daftar Pemesanan Online</h4>
          <small class="text-muted">Kelola pesanan yang masuk melalui website / aplikasi.</small>
        </div>
        <div class="d-flex gap-2">
          <select class="form-select form-select-sm" style="width: 180px;">
            <option>Semua Status</option>
            <option>Menunggu Pembayaran</option>
            <option>Sudah Dibayar</option>
            <option>Dibatalkan</option>
          </select>
          <select class="form-select form-select-sm" style="width: 160px;">
            <option>Semua Metode</option>
            <option>Transfer Bank</option>
            <option>COD</option>
            <option>QRIS</option>
          </select>
        </div>
      </div>

      <div class="card">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group input-group-sm" style="max-width: 260px;">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Cari ID / nama pelanggan">
            </div>
            <small class="text-muted">Menampilkan 1–10 pesanan</small>
          </div>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Id Pemesanan</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>No. HP</th>
                  <th>Metode</th>
                  <th>Total</th>
                  <th>Tgl Pesan</th>
                  <th>Status Pembayaran</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <!-- Contoh data statis, nanti ganti dengan looping backend -->
                <tr>
                  <td><span class="fw-semibold">ORD-20251101</span></td>
                  <td>Rina Anjani</td>
                  <td>Jl. Malioboro No. 10, Yogyakarta</td>
                  <td>0812-3456-7890</td>
                  <td>Transfer Bank</td>
                  <td>Rp 250.000</td>
                  <td>13 Nov 2025</td>
                  <td>
                    <span class="badge bg-warning text-dark badge-status">
                      <i class="bi bi-hourglass-split me-1"></i>Menunggu Pembayaran
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-dark">
                        <i class="bi bi-eye"></i> Detail
                      </button>
                      <!-- Tombol lihat bukti, kirim URL bukti lewat data-bukti -->
                      <button class="btn btn-outline-primary btn-lihat-bukti"
                              data-bs-toggle="modal"
                              data-bs-target="#modalBuktiTransfer"
                              data-bukti="{{ asset('images/bukti_transfer_rina.jpg') }}">
                        <i class="bi bi-file-earmark-image"></i> Bukti
                      </button>

                      <button class="btn btn-success btn-konfirmasi"
        data-bs-toggle="modal"
        data-bs-target="#modalKonfirmasiPembayaran"
        data-orderid="ORD-20251101">
  <i class="bi bi-check2-circle"></i> Konfirmasi
</button>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td><span class="fw-semibold">ORD-20251098</span></td>
                  <td>Budi Santoso</td>
                  <td>Jl. Kaliurang Km 7, Sleman</td>
                  <td>0821-1234-5678</td>
                  <td>QRIS</td>
                  <td>Rp 150.000</td>
                  <td>12 Nov 2025</td>
                  <td>
                    <span class="badge bg-success badge-status">
                      <i class="bi bi-check-circle me-1"></i>Sudah Dibayar
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-dark">
                        <i class="bi bi-eye"></i> Detail
                      </button>
                      <button class="btn btn-outline-primary btn-lihat-bukti"
                              data-bs-toggle="modal"
                              data-bs-target="#modalBuktiTransfer"
                              data-bukti="{{ asset('images/bukti_qris_budi.jpg') }}">
                        <i class="bi bi-file-earmark-image"></i> Bukti
                      </button>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td><span class="fw-semibold">ORD-20251090</span></td>
                  <td>Sari Wulandari</td>
                  <td>Jl. Solo Km 5, Yogyakarta</td>
                  <td>0857-9876-1234</td>
                  <td>COD</td>
                  <td>Rp 300.000</td>
                  <td>10 Nov 2025</td>
                  <td>
                    <span class="badge bg-danger badge-status">
                      <i class="bi bi-x-circle me-1"></i>Dibatalkan
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-dark">
                        <i class="bi bi-eye"></i> Detail
                      </button>
                      <!-- Untuk COD, tidak ada bukti transfer -->
                      <button class="btn btn-outline-secondary" disabled>
                        <i class="bi bi-file-earmark-image"></i> Tidak ada bukti
                      </button>
                    </div>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>

          <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm justify-content-end mb-0">
              <li class="page-item disabled">
                <a class="page-link">Sebelumnya</a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="#">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">Berikutnya</a>
              </li>
            </ul>
          </nav>

        </div>
      </div>
    </div>
  </main>

  <!-- MODAL LIHAT BUKTI TRANSFER / QRIS -->
  <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" aria-labelledby="modalBuktiTransferLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBuktiTransferLabel">Bukti Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          <!-- Gambar akan di-set lewat JavaScript -->
          <img id="imgBuktiTransfer" src="" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm">
        </div>
        <div class="modal-footer">
          {{-- Kalau nanti mau tombol download / approve tinggal tambah di sini --}}
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar   = document.getElementById('sidebar');
    const navbar    = document.getElementById('navbar');
    const content   = document.getElementById('content');

  </script>
</body>

</html>
