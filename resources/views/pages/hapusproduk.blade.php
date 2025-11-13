<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Hapus Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
 
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
      align-self: center
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
        <a href="#" class="nav-link"><i class="bi bi-cart4"></i> <span>Pemesanan Online</span></a>
        <a href="#" class="nav-link"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
        <hr class="my-2">
        <p class="nav-section-title mt-3">Produk</p>
        <a href="/tambah_produk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Lihat Produk</span></a>
       
        <a href="#" class="nav-link active"><i class="bi bi-trash3"></i> <span>Hapus Produk</span></a>
        <a href="/tambah_produk" class="nav-link"><i class="bi bi-plus-circle"></i> <span>Tambah Produk</span></a>
        <hr class="my-2">
      </div>
    </div>

    <div class="text-center mb-3">
      <a href="/login" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>

  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Admin Dashboard">
  </nav>

  <div class="content" id="content">
    <h1 class="h3 fw-bold mb-4">Hapus Produk</h1>

    <div class="card p-4">
      <p class="text-muted">Pilih produk yang ingin Anda hapus .</p>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col"></th>
              <th scope="col">Gambar</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Stok</th>
              <th scope="col">Harga</th>
              <th scope="col" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {{-- 'looping' data produk Anda di sini menggunakan @foreach --}}

            <tr>
              <th scope="row">1</th>
              <td>
                <img src="https://example.com/images/bakpia-cokelat.jpg" alt="Bakpia Cokelat"
                  style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
              </td>
              <td class="fw-bold">Bakpia Pathok Agung - Cokelat (Isi 15)</td>
              <td>150</td>
              <td>Rp 45.000</td>
              <td class="text-center">
                <button class="btn btn-danger btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#hapusModal"
                        data-id="1"
                        data-nama="Bakpia Pathok Agung - Cokelat (Isi 15)">
                  <i class="bi bi-trash"></i> Hapus
                </button>
              </td>
            </tr>

            <tr>
              <th scope="row">2</th>
              <td>
                <img src="https://example.com/images/bakpia-keju.jpg" alt="Bakpia Keju"
                  style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
              </td>
              <td class="fw-bold">Bakpia Pathok Agung - Keju (Isi 15)</td>
              <td>95</td>
              <td>Rp 45.000</td>
              <td class="text-center">
                 <button class="btn btn-danger btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#hapusModal"
                        data-id="2"
                        data-nama="Bakpia Pathok 25 - Keju (Isi 15)">
                  <i class="bi bi-trash"></i> Hapus
                </button>
              </td>
            </tr>

            <tr>
              <th scope="row">3</th>
              <td>
                <img src="https://example.com/images/bakpia-kacang.jpg" alt="Bakpia Kacang Hijau"
                  style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
              </td>
              <td class="fw-bold">Bakpia Pathok Agung - Kacang Hijau (Isi 20)</td>
              <td>210</td>
              <td>Rp 55.000</td>
              <td class="text-center">
                 <button class="btn btn-danger btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#hapusModal"
                        data-id="3"
                        data-nama="Bakpia Pathok Agung - Kacang Hijau (Isi 20)">
                  <i class="bi bi-trash"></i> Hapus
                </button>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="hapusModalLabel">
            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
            Konfirmasi Hapus Produk
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus produk:
          <br>
          <strong id="namaProdukHapus" class="text-dark"></strong>
          <br>
          <small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>
          
          <form action="/admin/produk/hapus" method="POST" id="formHapus" class="mt-3">
            @csrf
            @method('DELETE')
            
            <input type="hidden" name="id_produk" id="idProdukHapus"> 
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          
          <button type="submit" class="btn btn-danger" form="formHapus">Ya, Hapus</button>
        </div>
      </div>
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

  <script>

    const hapusModal = document.getElementById('hapusModal');
    
    const idProdukHapus = document.getElementById('idProdukHapus');
    const namaProdukHapus = document.getElementById('namaProdukHapus');

    hapusModal.addEventListener('show.bs.modal', (event) => {

      const button = event.relatedTarget;

      const id = button.getAttribute('data-id');
      const nama = button.getAttribute('data-nama');

      idProdukHapus.value = id;
      namaProdukHapus.textContent = nama;
    });
  </script>

</body>

</html>