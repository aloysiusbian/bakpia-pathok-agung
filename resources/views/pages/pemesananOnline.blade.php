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

    /* Samakan tinggi cell pada kolom aksi */
.table td.text-center {
  vertical-align: middle !important;
}

/* Pastikan tombol tidak merenggangkan baris */
.btn-group.btn-aksi {
  display: inline-flex;
  align-items: center;
}

/* Agar baris memiliki tinggi minimum */
.table > tbody > tr > td {
  height: 60px;               /* boleh ubah sesuai selera */
  vertical-align: middle;
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

    .filter-select {
      position: relative;
    }

    .filter-select i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.9rem;
      color: #a17a29;
      pointer-events: none;
    }

    .filter-select .form-select {
      padding-left: 2rem;
      border-radius: 999px;
      border: 1px solid #d4b36c;
      background-color: #fff7e1;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
      font-size: 0.85rem;
      font-weight: 500;
      color: #5a4525;
      transition: all 0.2s ease-in-out;
    }

    .filter-select .form-select:hover {
      background-color: #ffe9b6;
      border-color: #c8a04a;
    }

    .filter-select .form-select:focus {
      border-color: #f0b232;
      background-color: #fff3cc;
      box-shadow: 0 0 0 0.25rem rgba(240, 178, 50, 0.35);
    }

    .filter-select .form-select option {
      padding: 5px 8px;
      background: #fff;
      color: #5a4525;
    }

    .summary-card {
      border-radius: 14px;
      background: linear-gradient(135deg, #ffe2a4, #f5c24c);
      color: #4a3312;
    }

    .summary-card.secondary {
      background: linear-gradient(135deg, #f7e6c9, #d1b673);
    }

    .summary-card.danger {
      background: linear-gradient(135deg, #ffd6c7, #ff9b7a);
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
        <a href="/pemesananoffline" class="nav-link">
          <i class="bi bi-telephone"></i> <span>Pemesanan Offline</span>
        </a>

        <hr class="my-2">
        <p class="nav-section-title mt-3">Produk</p>
        <a href="/tambah_produk" class="nav-link">
          <i class="bi bi-box-seam"></i> <span>Lihat Produk</span>
        </a>

        <hr class="my-2">
        <p class="nav-section-title mt-3">Admin</p>
        <a href="/testambahakun" class="nav-link"><i class="bi bi-person-fill-add"></i> <span>Tambah Akun Admin</span></a>
        <a href="/teskelolaadmin" class="nav-link"><i class="bi bi-people-fill"></i> <span>Kelola Akun</span></a>
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
    <input type="text" class="form-control w-50 me-auto" placeholder="Cari pesanan online...">
    <span class="ms-3 fw-semibold">Pemesanan Online</span>
  </nav>

  <!-- CONTENT -->
  <main class="content" id="content">
    <div class="container-fluid">

      <!-- RINGKASAN -->
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <div class="card summary-card p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-uppercase fw-semibold">Total Pesanan Hari Ini</small>
                <h3 class="mb-0">28</h3>
                <small>Online (website + aplikasi)</small>
              </div>
              <i class="bi bi-cart4 fs-1 opacity-75"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card summary-card secondary p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-uppercase fw-semibold">Sudah Dibayar</small>
                <h3 class="mb-0">21</h3>
                <small>Nilai: Rp 4.500.000</small>
              </div>
              <i class="bi bi-check-circle fs-1 opacity-75"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card summary-card danger p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-uppercase fw-semibold">Menunggu Pembayaran</small>
                <h3 class="mb-0">7</h3>
                <small>Segera follow-up pelanggan</small>
              </div>
              <i class="bi bi-hourglass-split fs-1 opacity-75"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- FILTER & JUDUL -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h4 class="mb-0">Daftar Pemesanan Online</h4>
          <small class="text-muted">Kelola pesanan yang masuk melalui website / aplikasi.</small>
        </div>
        <div class="d-flex gap-2">
          <div class="filter-select" style="width: 180px;">
            <i class="bi bi-sliders"></i>
            <select class="form-select form-select-sm">
              <option>Semua Status</option>
              <option>Menunggu Pembayaran</option>
              <option>Sudah Dibayar</option>
              <option>Dibatalkan</option>
            </select>
          </div>

          <div class="filter-select" style="width: 160px;">
            <i class="bi bi-credit-card"></i>
            <select class="form-select form-select-sm">
              <option>Semua Metode</option>
              <option>Transfer Bank</option>
              <option>COD</option>
              <option>QRIS</option>
            </select>
          </div>
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

          <!-- TABEL: HANYA ID + STATUS + AKSI -->
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Id Pemesanan</th>
                  <th>Status Pembayaran</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <!-- Rina -->
                <tr>
                  <td><span class="fw-semibold">ORD-20251101</span></td>
                  <td>
                    <span class="badge bg-warning text-dark badge-status">
                      <i class="bi bi-hourglass-split me-1"></i>Menunggu Pembayaran
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-dark btn-detail"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDetailPesanan"
                              data-orderid="ORD-20251101"
                              data-nama="Rina Anjani"
                              data-alamat="Jl. Malioboro No. 10, Yogyakarta"
                              data-hp="0812-3456-7890"
                              data-metode="Transfer Bank"
                              data-total="Rp 250.000"
                              data-tgl="13 Nov 2025"
                              data-status="Menunggu Pembayaran">
                        <i class="bi bi-eye"></i> Detail
                      </button>
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

                <!-- Budi -->
                <tr>
                  <td><span class="fw-semibold">ORD-20251098</span></td>
                  <td>
                    <span class="badge bg-success badge-status">
                      <i class="bi bi-check-circle me-1"></i>Sudah Dibayar
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-dark btn-detail"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDetailPesanan"
                              data-orderid="ORD-20251098"
                              data-nama="Budi Santoso"
                              data-alamat="Jl. Kaliurang Km 7, Sleman"
                              data-hp="0821-1234-5678"
                              data-metode="QRIS"
                              data-total="Rp 150.000"
                              data-tgl="12 Nov 2025"
                              data-status="Sudah Dibayar">
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

                <!-- Sari -->
                <tr>
                  <td><span class="fw-semibold">ORD-20251090</span></td>
                  <td>
                    <span class="badge bg-danger badge-status">
                      <i class="bi bi-x-circle me-1"></i>Dibatalkan
                    </span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-dark btn-detail"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDetailPesanan"
                              data-orderid="ORD-20251090"
                              data-nama="Sari Wulandari"
                              data-alamat="Jl. Solo Km 5, Yogyakarta"
                              data-hp="0857-9876-1234"
                              data-metode="COD"
                              data-total="Rp 300.000"
                              data-tgl="10 Nov 2025"
                              data-status="Dibatalkan">
                        <i class="bi bi-eye"></i> Detail
                      </button>
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

  <!-- MODAL LIHAT BUKTI -->
  <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" aria-labelledby="modalBuktiTransferLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBuktiTransferLabel">Bukti Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          <img id="imgBuktiTransfer" src="" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL KONFIRMASI -->
  <div class="modal fade" id="modalKonfirmasiPembayaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin mengkonfirmasi pembayaran untuk pesanan <span id="orderIdSpan" class="fw-semibold"></span>?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-success">Ya, Konfirmasi</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL DETAIL PESANAN -->
  <div class="modal fade" id="modalDetailPesanan" tabindex="-1" aria-labelledby="modalDetailPesananLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailPesananLabel">Detail Pesanan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-md-6">
              <p class="mb-1"><strong>ID Pemesanan:</strong> <span id="detailOrderId"></span></p>
              <p class="mb-1"><strong>Nama Pelanggan:</strong> <span id="detailNama"></span></p>
              <p class="mb-1"><strong>No. HP:</strong> <span id="detailHp"></span></p>
              <p class="mb-1"><strong>Tanggal Pesan:</strong> <span id="detailTgl"></span></p>
            </div>
            <div class="col-md-6">
              <p class="mb-1"><strong>Alamat:</strong><br><span id="detailAlamat"></span></p>
              <p class="mb-1"><strong>Metode Pembayaran:</strong> <span id="detailMetode"></span></p>
              <p class="mb-1"><strong>Total:</strong> <span id="detailTotal"></span></p>
              <p class="mb-1"><strong>Status Pembayaran:</strong> <span id="detailStatus"></span></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

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

    // set gambar bukti dari data-bukti
    const buktiButtons = document.querySelectorAll('.btn-lihat-bukti');
    const imgBuktiTransfer = document.getElementById('imgBuktiTransfer');

    buktiButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const src = btn.getAttribute('data-bukti');
        imgBuktiTransfer.src = src;
      });
    });

    // set ID pesanan ke modal konfirmasi
    const konfirmasiButtons = document.querySelectorAll('.btn-konfirmasi');
    const orderIdSpan = document.getElementById('orderIdSpan');

    konfirmasiButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const orderId = btn.getAttribute('data-orderid');
        orderIdSpan.textContent = orderId;
      });
    });

    // set detail pesanan ke modal detail
    const detailButtons = document.querySelectorAll('.btn-detail');

    const detailOrderId = document.getElementById('detailOrderId');
    const detailNama = document.getElementById('detailNama');
    const detailAlamat = document.getElementById('detailAlamat');
    const detailHp = document.getElementById('detailHp');
    const detailMetode = document.getElementById('detailMetode');
    const detailTotal = document.getElementById('detailTotal');
    const detailTgl = document.getElementById('detailTgl');
    const detailStatus = document.getElementById('detailStatus');

    detailButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        detailOrderId.textContent = btn.dataset.orderid;
        detailNama.textContent = btn.dataset.nama;
        detailAlamat.textContent = btn.dataset.alamat;
        detailHp.textContent = btn.dataset.hp;
        detailMetode.textContent = btn.dataset.metode;
        detailTotal.textContent = btn.dataset.total;
        detailTgl.textContent = btn.dataset.tgl;
        detailStatus.textContent = btn.dataset.status;
      });
    });
  </script>
</body>

</html>
