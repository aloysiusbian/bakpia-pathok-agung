<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pelanggan | Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fbf3df;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* Sidebar */
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

    .form-control:focus {
      box-shadow: 0 0 5px rgba(241, 173, 24, 0.8);
      border-color: #e2b13c;
    }

    .btn-save {
      background-color: #f5c24c;
      color: #000;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.2s;
    }

    .btn-save:hover {
      background-color: #e0a918;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
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
        <img src="{{ asset('images/bian.png') }}" alt="Pelanggan">
        <h6>{{ Auth::user()->name ?? 'Reza Saputra' }}</h6>
      </div>

      <div class="menu px-2">
        <hr>
        <p class="nav-section-title">Menu Utama</p>
        <a href="/testes" class="nav-link"><i class="bi bi-house-door"></i> <span>Beranda</span></a>
        <a href="/tesedit" class="nav-link active"><i class="bi bi-person-circle"></i> <span>Edit Profil</span></a>
        <a href="/tesriwayat" class="nav-link"><i class="bi bi-clock-history"></i> <span>Riwayat Pembelian</span></a>
        <hr>
      </div>
    </div>

    <div class="text-center mb-3">
      <a href="/" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Kembali? </a>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Edit Profil">
  </nav>

  <!-- CONTENT -->
  <div class="content" id="content">
    <div class="container">
      <div class="card p-4">
        <h4 class="fw-bold mb-4" style="color:#3a2d1a;">
          <i class="bi bi-person-lines-fill me-2"></i>Edit Profil
        </h4>

        @php
            // opsional: kirim $primaryAddress dari controller (hasil decode JSON alamat utama)
            $primaryAddress = $primaryAddress ?? null;
            $label = $primaryAddress['labelAlamat'] ?? 'Rumah';
        @endphp

        <form action="/tesedit" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- DATA PROFIL -->
          <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ Auth::user()->name ?? '' }}" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="{{ Auth::user()->email ?? '' }}" required>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Nomor Telepon Akun</label>
            <input type="text" class="form-control" id="phone" name="phone"
                   value="{{ Auth::user()->phone ?? '' }}">
          </div>

          <hr class="my-4">

          <!-- ALAMAT PENGIRIMAN UTAMA (MODEL TOKOPEDIA) -->
          <h5 class="fw-bold mb-3" style="color:#3a2d1a;">Alamat Pengiriman Utama</h5>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Penerima</label>
              <input type="text" class="form-control"
                     name="address[namaPenerima]"
                     value="{{ $primaryAddress['namaPenerima'] ?? Auth::user()->name ?? '' }}"
                     required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nomor Telepon Penerima</label>
              <input type="text" class="form-control"
                     name="address[noTelp]"
                     value="{{ $primaryAddress['noTelp'] ?? Auth::user()->phone ?? '' }}"
                     required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Label Alamat</label>
              <select class="form-select" name="address[labelAlamat]">
                <option value="Rumah"  {{ $label == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                <option value="Kantor" {{ $label == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                <option value="Lainnya" {{ $label == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Provinsi</label>
              <input type="text" class="form-control"
                     name="address[provinsi]"
                     value="{{ $primaryAddress['provinsi'] ?? '' }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Kota / Kabupaten</label>
              <input type="text" class="form-control"
                     name="address[kota]"
                     value="{{ $primaryAddress['kota'] ?? '' }}" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Kecamatan</label>
              <input type="text" class="form-control"
                     name="address[kecamatan]"
                     value="{{ $primaryAddress['kecamatan'] ?? '' }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Kode Pos</label>
              <input type="text" class="form-control"
                     name="address[kodePos]"
                     value="{{ $primaryAddress['kodePos'] ?? '' }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" rows="3"
                      name="address[alamatLengkap]" required>{{ $primaryAddress['alamatLengkap'] ?? '' }}</textarea>
            <small class="text-muted">
              Contoh: Jl. Mawar No. 1, RT 02 RW 03, dekat minimarket, warna rumah hijau.
            </small>
          </div>

          <div class="mb-3">
            <label class="form-label">Catatan untuk Kurir (Opsional)</label>
            <input type="text" class="form-control"
                   name="address[catatanKurir]"
                   value="{{ $primaryAddress['catatanKurir'] ?? '' }}"
                   placeholder="Contoh: Tolong hubungi dulu sebelum kirim">
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox"
                   id="isDefault" name="address[isDefault]"
                   value="1" {{ ($primaryAddress['isDefault'] ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isDefault">
              Jadikan sebagai alamat utama
            </label>
          </div>

          <!-- FOTO PROFIL -->
          <div class="mb-3">
            <label for="profile_image" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image">
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-save px-4">
              <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
          </div>
        </form>
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
