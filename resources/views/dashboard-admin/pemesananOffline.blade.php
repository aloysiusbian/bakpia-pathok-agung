@extends('templates.sidebar-admin')

@section('title', 'Pemesanan Offline')

@section('content')
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

                <form action="#" method="POST">
                    @csrf

                    <!-- DATA PELANGGAN -->
                    <div class="mb-3">
                        <div class="section-title">Data Pelanggan</div>
                        <small class="text-muted">Bisa diisi singkat, cukup untuk identifikasi & kontak.</small>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pelanggan" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. HP / WA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Contoh: 0812-3456-7890">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sumber Pesanan <span class="text-danger">*</span></label>
                            <select class="form-select" name="sumber_pesanan">
                                <option value="">-- Pilih --</option>
                                <option value="Telepon">Telepon</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Datang Langsung">Datang Langsung</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Alamat (opsional)</label>
                            <textarea rows="2" class="form-control" name="alamat"
                                      placeholder="Isi jika pesanan dikirim ke alamat pelanggan"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea rows="2" class="form-control" name="catatan"
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

                        <!-- ROW PRODUK PERTAMA -->
                        <div class="produk-row row g-2 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label mb-1">Produk</label>

                                <div class="product-dropdown">
                                    <button type="button" class="product-dropdown-toggle">
                                        <div class="selected-info">
                                            <span class="placeholder-text">-- Pilih Produk --</span>
                                        </div>
                                        <span><i class="bi bi-chevron-down"></i></span>
                                    </button>

                                    <input type="hidden" name="produk[]" class="input-produk">
                                    <div class="product-dropdown-menu d-none"></div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label mb-1">Jumlah</label>
                                <input type="number" min="1" class="form-control" value="1" name="jumlah[]">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label mb-1">Harga Satuan (Rp)</label>
                                <input type="number" min="0" class="form-control" name="harga_satuan[]">
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
                            <input type="date" class="form-control" name="tanggal_pesan">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Ambil / Kirim</label>
                            <input type="date" class="form-control" name="tanggal_ambil">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select" name="metode_pembayaran">
                                <option value="">-- Pilih Metode --</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Total Tagihan (Rp)</label>
                            <input type="number" min="0" class="form-control" name="total_tagihan">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Uang Diterima (Rp)</label>
                            <input type="number" min="0" class="form-control" name="uang_diterima">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Kasir / Admin</label>
                            <input type="text" class="form-control" name="nama_kasir" placeholder="Contoh: Berto">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Pesanan ini akan tampil di menu <strong>Pemesanan Offline</strong> pada dashboard.
                        </small>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-secondary btn-sm">Reset</button>
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

{{-- ====== INI YANG PENTING: dataProduk dari DB ====== --}}
<script>
    const dataProduk = @json($produk);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar toggle (punyamu)
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar?.classList.toggle('collapsed');
            navbar?.classList.toggle('collapsed');
            content?.classList.toggle('collapsed');
        });
    }

    // build option list dari dataProduk (DB)
    function buildOptionsHtml() {
        return dataProduk.map(p => `
            <div class="product-option" data-value="${p.id}">
                <img src="${p.gambar}" alt="${p.nama}">
                <div>
                    <div class="product-option-name">${p.nama}</div>
                    <div class="product-option-stock">Stok: ${p.stok}</div>
                </div>
            </div>
        `).join('');
    }

    function initProductDropdown(wrapper) {
        const toggle = wrapper.querySelector('.product-dropdown-toggle');
        const menu = wrapper.querySelector('.product-dropdown-menu');
        const hiddenInput = wrapper.querySelector('.input-produk');
        const selectedInfo = toggle.querySelector('.selected-info');

        // cari input harga dalam row yg sama (auto isi)
        const row = wrapper.closest('.produk-row');
        const inputHarga = row.querySelector('input[name="harga_satuan[]"]');

        menu.innerHTML = buildOptionsHtml();

        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.product-dropdown-menu').forEach(m => {
                if (m !== menu) m.classList.add('d-none');
            });
            menu.classList.toggle('d-none');
        });

        menu.querySelectorAll('.product-option').forEach(opt => {
            opt.addEventListener('click', () => {
                const id = opt.getAttribute('data-value');
                const produk = dataProduk.find(p => String(p.id) === String(id));
                if (!produk) return;

                hiddenInput.value = produk.id;
                menu.classList.add('d-none');

                selectedInfo.innerHTML = `
                    <img src="${produk.gambar}" alt="${produk.nama}">
                    <div>
                        <div class="product-option-name">${produk.nama}</div>
                        <div class="product-option-stock">Stok: ${produk.stok}</div>
                    </div>
                `;

                if (inputHarga) inputHarga.value = produk.harga;
            });
        });
    }

    // tutup semua dropdown kalau klik di luar
    document.addEventListener('click', () => {
        document.querySelectorAll('.product-dropdown-menu').forEach(m => m.classList.add('d-none'));
    });

    const produkWrapper = document.getElementById('produkWrapper');
    initProductDropdown(produkWrapper.querySelector('.product-dropdown'));

    // tombol tambah produk
    document.getElementById('btnTambahProduk').addEventListener('click', () => {
        const row = document.createElement('div');
        row.classList.add('produk-row', 'row', 'g-2', 'align-items-end');

        row.innerHTML = `
            <div class="col-md-5">
                <label class="form-label mb-1">Produk</label>
                <div class="product-dropdown">
                    <button type="button" class="product-dropdown-toggle">
                        <div class="selected-info">
                            <span class="placeholder-text">-- Pilih Produk --</span>
                        </div>
                        <span><i class="bi bi-chevron-down"></i></span>
                    </button>
                    <input type="hidden" name="produk[]" class="input-produk">
                    <div class="product-dropdown-menu d-none"></div>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label mb-1">Jumlah</label>
                <input type="number" min="1" class="form-control" value="1" name="jumlah[]">
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1">Harga Satuan (Rp)</label>
                <input type="number" min="0" class="form-control" name="harga_satuan[]">
            </div>

            <div class="col-md-2 text-md-end">
                <button type="button" class="btn btn-outline-danger btn-sm btnHapusProduk mt-1">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        produkWrapper.appendChild(row);

        row.querySelector('.btnHapusProduk').addEventListener('click', () => row.remove());

        initProductDropdown(row.querySelector('.product-dropdown'));
    });
</script>
@endsection
