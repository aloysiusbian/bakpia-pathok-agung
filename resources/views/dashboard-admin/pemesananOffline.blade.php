@extends('templates.sidebar-admin')

@section('title', 'Pemesanan Offline')

@section('content')

  <!-- CONTENT -->
  <main class="content" id="content">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h4 class="mb-0"><b>Form Pemesanan Offline</b></h4>
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
                  <option>Reseller / Agen</option>
                </select>
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-8">
                <label class="form-label">Alamat (opsional)</label>
                <textarea rows="2" class="form-control"
                  placeholder="Isi jika pesanan dikirim ke alamat pelanggan"></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label">Catatan (opsional)</label>
                <textarea rows="2" class="form-control"
                  placeholder="Contoh: Pelanggan langganan, minta lebih matang, dsb"></textarea>
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
                  <option>Tempo / Bon</option>
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
                  <input type="text" class="form-control" placeholder="Contoh: Sari">
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

@endsection