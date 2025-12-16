@extends('templates.sidebar-admin')

@section('title', 'Pemesanan Offline')

@section('content')
<main class="content" id="content">
    <div class="container-fluid">
        {{-- === KODE PENAMPIL ERROR === --}}
    
    {{-- 1. Menampilkan Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. Menampilkan Pesan Error dari Controller (Try-Catch) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> <strong>Gagal Menyimpan:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. Menampilkan Error Validasi (Misal: Nama wajib diisi, dll) --}}
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i> <strong>Periksa Inputan Anda:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- === END KODE PENAMPIL ERROR === --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">Form Pemesanan Offline</h4>
                <small class="text-muted">
                    Digunakan untuk mencatat pesanan yang masuk via telepon, WhatsApp, atau pelanggan datang langsung ke toko.
                </small>
            </div>
            <a href="/admin/pemesanan-offline" class="btn btn-outline-theme btn-sm">
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

                <form action="/admin/pemesanan-offline" method="POST">
                    @csrf

                    <div class="mb-3">
                        <div class="section-title">Data Pelanggan</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaPelanggan" required placeholder="Contoh: Budi Santoso">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. HP / WA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="noTelpPelanggan" required placeholder="Contoh: 0812...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sumber Pesanan</label>
                            <select class="form-select" name="sumberPesanan">
                                <option value="Datang Langsung">Datang Langsung</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Telepon">Telepon</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Alamat Pengirim <span class="text-danger">*</span></label>
                            <textarea rows="2" class="form-control" name="alamatPengirim" required placeholder="Isi alamat lengkap"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea rows="2" class="form-control" name="catatan" placeholder="Contoh: Pelanggan langganan..."></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div class="section-title">Detail Produk Pesanan</div>
                        <small class="text-muted">Pilih produk dan jumlah yang dipesan.</small>
                    </div>

                    <div id="produkWrapper" class="mb-3">
                        <div class="produk-row row g-2 align-items-end mb-2">
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
                                <input type="number" min="0" class="form-control bg-light" name="harga_satuan[]" readonly>
                            </div>

                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-theme btn-sm mt-1" id="btnTambahProduk">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="section-title">Informasi Transaksi</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Pesan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggalPemesanan" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select" name="metodePembayaran" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Total Tagihan (Rp)</label>
                            {{-- Input Total Tagihan (Kotor) --}}
                            <input type="number" class="form-control" name="total_tagihan" id="inputTotalTagihan" readonly placeholder="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Diskon (%)</label>
                            {{-- Input Diskon (Persen) --}}
                            <input type="number" class="form-control" name="discountPerNota" id="inputDiskon" placeholder="0" min="0" max="100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total Nota / Bersih (Rp)</label>
                            {{-- Input Total Nota (Hasil Akhir) --}}
                            <input type="number" class="form-control" name="uang_diterima" id="inputTotalNota" readonly placeholder="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Pastikan data sudah benar sebelum disimpan.
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

{{-- SCRIPT JAVASCRIPT --}}
<script>
    const dataProduk = @json($produk);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // --- 1. LOGIKA UTILS (Sidebar) ---
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar?.classList.toggle('collapsed');
            document.getElementById('navbar')?.classList.toggle('collapsed');
            document.getElementById('content')?.classList.toggle('collapsed');
        });
    }

    // --- 2. LOGIKA UTAMA: HITUNG TAGIHAN & NOTA ---
    function updateKalkulasi() {
        let totalKotor = 0;
        
        // Loop semua baris produk untuk hitung total kotor
        const rows = document.querySelectorAll('.produk-row');
        rows.forEach(row => {
            const inputJumlah = row.querySelector('input[name="jumlah[]"]');
            const inputHarga = row.querySelector('input[name="harga_satuan[]"]');
            
            // Pakai '0' jika input kosong/invalid
            const qty = parseFloat(inputJumlah.value) || 0;
            const harga = parseFloat(inputHarga.value) || 0;

            totalKotor += (qty * harga);
        });

        // Tampilkan Total Tagihan (Kotor)
        const elTotalTagihan = document.getElementById('inputTotalTagihan');
        if(elTotalTagihan) elTotalTagihan.value = totalKotor;

        // Ambil nilai Diskon
        const elDiskon = document.getElementById('inputDiskon');
        const diskonPersen = parseFloat(elDiskon.value) || 0;

        // Hitung Potongan & Total Bersih
        const potongan = totalKotor * (diskonPersen / 100);
        const totalBersih = totalKotor - potongan;

        // Tampilkan Total Nota (Bersih) ke kolom 'uang_diterima'
        const elTotalNota = document.getElementById('inputTotalNota');
        if(elTotalNota) elTotalNota.value = Math.round(totalBersih);
    }

    // --- 3. LOGIKA DROPDOWN & EVENT LISTENER PER BARIS ---
    function buildOptionsHtml() {
        return dataProduk.map(p => `
            <div class="product-option" data-value="${p.id}">
                <img src="${p.gambar}" alt="${p.nama}">
                <div>
                    <div class="product-option-name">${p.nama}</div>
                    <div class="product-option-stock small text-muted">Stok: ${p.stok}</div>
                </div>
            </div>
        `).join('');
    }

    function initRowEvents(row) {
        const toggle = row.querySelector('.product-dropdown-toggle');
        const menu = row.querySelector('.product-dropdown-menu');
        const hiddenInput = row.querySelector('.input-produk');
        const selectedInfo = toggle.querySelector('.selected-info');
        const inputHarga = row.querySelector('input[name="harga_satuan[]"]');
        const inputJumlah = row.querySelector('input[name="jumlah[]"]');
        const btnHapus = row.querySelector('.btnHapusProduk');

        menu.innerHTML = buildOptionsHtml();

        // Toggle Menu
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.product-dropdown-menu').forEach(m => {
                if(m !== menu) m.classList.add('d-none');
            });
            menu.classList.toggle('d-none');
        });

        // Pilih Produk
        menu.querySelectorAll('.product-option').forEach(opt => {
            opt.addEventListener('click', () => {
                const id = opt.getAttribute('data-value');
                const produk = dataProduk.find(p => String(p.id) === String(id));
                if(!produk) return;

                hiddenInput.value = produk.id;
                menu.classList.add('d-none');
                
                // Update UI Dropdown
                selectedInfo.innerHTML = `
                    <div class="d-flex align-items-center">
                        <img src="${produk.gambar}" style="width:30px; height:30px; object-fit:cover; margin-right:8px;">
                        <span>${produk.nama}</span>
                    </div>
                `;
                
                // Isi Harga Otomatis & HITUNG ULANG
                if(inputHarga) {
                    inputHarga.value = produk.harga;
                    updateKalkulasi(); // <--- PENTING: Hitung saat produk dipilih
                }
            });
        });

        // Event listener jika jumlah diubah manual
        if(inputJumlah) {
            inputJumlah.addEventListener('input', updateKalkulasi);
        }

        // Hapus Baris
        if(btnHapus) {
            btnHapus.addEventListener('click', () => {
                row.remove();
                updateKalkulasi(); // <--- PENTING: Hitung saat baris dihapus
            });
        }
    }

    // --- 4. INISIALISASI GLOBAL ---
    
    // Tutup dropdown saat klik luar
    document.addEventListener('click', () => {
        document.querySelectorAll('.product-dropdown-menu').forEach(m => m.classList.add('d-none'));
    });

    // Event Listener untuk Kolom Diskon
    const elDiskonGlobal = document.getElementById('inputDiskon');
    if(elDiskonGlobal) {
        elDiskonGlobal.addEventListener('input', updateKalkulasi);
    }

    // Inisialisasi baris pertama saat halaman dimuat
    const firstRow = document.querySelector('.produk-row');
    if(firstRow) initRowEvents(firstRow);

    // Tombol Tambah Produk
    document.getElementById('btnTambahProduk').addEventListener('click', () => {
        const wrapper = document.getElementById('produkWrapper');
        const row = document.createElement('div');
        row.className = 'produk-row row g-2 align-items-end mb-2';
        
        row.innerHTML = `
            <div class="col-md-5">
                <label class="form-label mb-1">Produk</label>
                <div class="product-dropdown">
                    <button type="button" class="product-dropdown-toggle w-100 text-start btn btn-outline-secondary d-flex justify-content-between align-items-center">
                        <div class="selected-info"><span class="placeholder-text">-- Pilih Produk --</span></div>
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
                <input type="number" readonly class="form-control bg-light" name="harga_satuan[]">
            </div>
            <div class="col-md-2 text-md-end">
                <button type="button" class="btn btn-outline-danger btn-sm mt-1 btnHapusProduk">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        
        wrapper.appendChild(row);
        initRowEvents(row); // Pasang logic ke baris baru
    });
</script>
@endsection