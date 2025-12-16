@extends('templates.sidebar-admin')

@section('title', 'Pemesanan Online')

@section('content')

  <main class="content" id="content">
    <div class="container-fluid">

      {{-- 1. Bagian Summary Cards --}}
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <div class="card summary-card p-3 shadow-sm bg-light">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-uppercase fw-semibold text-primary">Total Pesanan Hari Ini</small>
                <h3 class="mb-0">{{ $summary['total_today'] ?? 0 }}</h3>
                <small>Online (website + aplikasi)</small>
              </div>
              <i class="bi bi-cart4 fs-1 opacity-75 text-primary"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card summary-card p-3 shadow-sm bg-light">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-uppercase fw-semibold text-success">Sudah Dibayar</small>
                <h3 class="mb-0">{{ $summary['paid_count'] ?? 0 }}</h3>
                <small>Nilai: Rp {{ number_format($summary['paid_amount'] ?? 0, 0, ',', '.') }}</small>
              </div>
              <i class="bi bi-check-circle fs-1 opacity-75 text-success"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card summary-card p-3 shadow-sm bg-light">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-uppercase fw-semibold text-danger">Menunggu Pembayaran</small>
                <h3 class="mb-0">{{ $summary['pending_count'] ?? 0 }}</h3>
                <small>Segera follow-up pelanggan</small>
              </div>
              <i class="bi bi-hourglass-split fs-1 opacity-75 text-danger"></i>
            </div>
          </div>
        </div>
      </div>

      {{-- 2. Header & Alert --}}
      <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
          <h4 class="mb-0">Daftar Pemesanan Online</h4>
          <small class="text-muted">Kelola pesanan yang masuk melalui website / aplikasi.</small>
        </div>
      </div>

      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      {{-- 3. Tabel Pesanan --}}
      <div class="card shadow-lg border-0">
        <div class="card-body">
          
          {{-- Search & Pagination Info --}}
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group input-group-sm" style="max-width: 260px;">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Cari ID / nama pelanggan">
            </div>
            <small class="text-muted">
              Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} dari
              {{ $orders->total() ?? 0 }} pesanan
            </small>
          </div>

          <div class="table-responsive">
            <table class="table align-middle table-hover">
              <thead>
                <tr class="text-sm">
                  <th>Id Pemesanan</th>
                  <th>Status Pembayaran</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($orders as $order)
                  <tr>
                    <td><span class="fw-semibold">{{ $order->nomorPemesanan }}</span></td>
                    <td>
                      @php
                        $status = $order->statusPesanan ?? 'Dibatalkan';
                        $statusClass = [
                          'menunggu_pembayaran' => 'bg-warning text-dark',
                          'diproses' => 'bg-success',
                          'batal' => 'bg-danger',
                          'selesai' => 'bg-success',
                        ][$status] ?? 'bg-secondary';
                        
                        $statusIcon = [
                          'menunggu_pembayaran' => 'bi-hourglass-split',
                          'diproses' => 'bi-check-circle',
                          'batal' => 'bi-x-circle',
                          'selesai' => 'bi-check-circle',
                        ][$status] ?? 'bi-question-circle';
                      @endphp

                      <span class="badge {{ $statusClass }} badge-status">
                        <i class="bi {{ $statusIcon }} me-1"></i>{{ $status }}
                      </span>
                    </td>

                    <td class="text-center">
                      <div class="btn-group btn-group-sm" role="group">
                        {{-- TOMBOL DETAIL (Memicu Modal Detail) --}}
                        {{-- PERBAIKAN: Menambahkan data-items yang berisi JSON produk --}}
                        <button class="btn btn-outline-dark btn-detail" data-bs-toggle="modal"
                          data-bs-target="#modalDetailPesanan" 
                          data-orderid="{{ $order->nomorPemesanan }}"
                          data-nama="{{ $order->pelanggan->username ?? 'Nama Tidak Tersedia' }}"
                          data-alamat="{{ $order->alamatPengirim }}" 
                          data-hp="{{ $order->pelanggan->noTelp ?? '-' }}"
                          data-metode="{{ $order->metodePembayaran }}"
                          data-total="Rp {{ number_format($order->totalNota, 0, ',', '.') }}"
                          data-tgl="{{ \Carbon\Carbon::parse($order->tanggalPemesanan)->format('d M Y') }}"
                          data-status="{{ $order->statusPesanan }}"
                          data-items="{{ json_encode($order->detailTransaksiOnline->map(function($item){
                              return [
                                  'nama' => $item->produk->namaProduk ?? 'Produk Dihapus',
                                  'qty' => $item->jumlahBarang,
                                  'harga' => $item->harga
                              ];
                          })) }}">
                          <i class="bi bi-eye"></i> Detail
                        </button>

                        {{-- TOMBOL BUKTI PEMBAYARAN --}}
                        @if ($order->buktiPembayaran)
                          <button class="btn btn-outline-primary btn-lihat-bukti" data-bs-toggle="modal"
                            data-bs-target="#modalBuktiTransfer" data-bukti="{{ asset($order->buktiPembayaran) }}">
                            <i class="bi bi-file-earmark-image"></i> Bukti
                          </button>
                        @else
                          <button class="btn btn-outline-secondary" disabled>
                            <i class="bi bi-file-earmark-image"></i> Tidak ada bukti
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada pesanan yang ditemukan.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination Links --}}
          @if(isset($orders) && method_exists($orders, 'links'))
            <nav aria-label="Page navigation" class="mt-4">
              {{ $orders->links('pagination::bootstrap-5') }}
            </nav>
          @endif

        </div>
      </div>
    </div>
  </main>

  {{-- 4. Modal Bukti Transfer --}}
  <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bukti Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

  {{-- 5. Modal Detail Pesanan & Konfirmasi --}}
  <div class="modal fade" id="modalDetailPesanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Pesanan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-md-6">
              <p class="mb-1"><strong>ID Pemesanan:</strong> <span id="detailOrderId" class="fw-semibold"></span></p>
              <p class="mb-1"><strong>Nama Pelanggan:</strong> <span id="detailNama"></span></p>
              <p class="mb-1"><strong>No. HP:</strong> <span id="detailHp"></span></p>
              <p class="mb-1"><strong>Tanggal Pesan:</strong> <span id="detailTgl"></span></p>
            </div>
            <div class="col-md-6">
              <p class="mb-1"><strong>Alamat:</strong><br><span id="detailAlamat"></span></p>
              <p class="mb-1"><strong>Metode Pembayaran:</strong> <span id="detailMetode"></span></p>
              <p class="mb-1"><strong>Total:</strong> <span id="detailTotal" class="fw-bold text-lg text-primary"></span></p>
              <p class="mb-1"><strong>Status Pembayaran:</strong> <span id="detailStatus" class="fw-semibold"></span></p>
            </div>
          </div>

          <h6 class="mt-4 mb-3 border-bottom pb-1">Item Pesanan</h6>
          <table class="table table-sm table-bordered">
            <thead>
              <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga Satuan</th>
              </tr>
            </thead>
            {{-- PERBAIKAN: Menambahkan ID pada tbody --}}
            <tbody id="detailItemsBody">
              {{-- Data akan diisi lewat Javascript --}}
            </tbody>
          </table>
        </div>

        {{-- FOOTER MODAL --}}
        <div class="modal-footer position-relative justify-content-center">
            
            <form id="formKonfirmasiDetail" method="POST" action="" style="display: none;">
                @csrf
                {{-- @method('PUT') --}} 
                <button type="submit" class="btn btn-success px-4" onclick="return confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')">
                    <i class="bi bi-check-circle"></i> Konfirmasi Pembayaran
                </button>
            </form>

            <button type="button" class="btn btn-secondary position-absolute end-0 me-3" data-bs-dismiss="modal">
                Tutup
            </button>

        </div>
      </div>
    </div>
  </div>

  <style>
    .badge-status { padding: 5px 10px; border-radius: 12px; font-size: 0.85rem; }
    .summary-card { transition: transform 0.2s; border: none; }
    .summary-card:hover { transform: translateY(-3px); }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // 1. Script Bukti Transfer
    const buktiButtons = document.querySelectorAll('.btn-lihat-bukti');
    const imgBuktiTransfer = document.getElementById('imgBuktiTransfer');
    buktiButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        imgBuktiTransfer.src = btn.getAttribute('data-bukti');
      });
    });

    // 2. Script Detail & Konfirmasi
    const detailButtons = document.querySelectorAll('.btn-detail');
    
    // Elemen Data Detail (Text)
    const detailOrderId = document.getElementById('detailOrderId');
    const detailNama = document.getElementById('detailNama');
    const detailAlamat = document.getElementById('detailAlamat');
    const detailHp = document.getElementById('detailHp');
    const detailMetode = document.getElementById('detailMetode');
    const detailTotal = document.getElementById('detailTotal');
    const detailTgl = document.getElementById('detailTgl');
    const detailStatus = document.getElementById('detailStatus');
    
    // PERBAIKAN: Elemen Tbody untuk Item
    const detailItemsBody = document.getElementById('detailItemsBody');

    // Elemen Form Konfirmasi
    const formKonfirmasiDetail = document.getElementById('formKonfirmasiDetail');

    detailButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        // Ambil data dari atribut tombol
        const orderId = btn.dataset.orderid;
        const status = btn.dataset.status;

        // Isi Modal dengan Data Utama
        detailOrderId.textContent = orderId;
        detailNama.textContent = btn.dataset.nama;
        detailAlamat.textContent = btn.dataset.alamat;
        detailHp.textContent = btn.dataset.hp;
        detailMetode.textContent = btn.dataset.metode;
        detailTotal.textContent = btn.dataset.total;
        detailTgl.textContent = btn.dataset.tgl;
        detailStatus.textContent = status;

        // PERBAIKAN: Isi Tabel Item Pesanan
        const items = JSON.parse(btn.dataset.items || '[]'); // Ambil JSON dari data-items
        detailItemsBody.innerHTML = ''; // Kosongkan tabel dulu

        if(items.length > 0) {
            items.forEach(item => {
                // Format Rupiah sederhana di JS
                const hargaFormatted = new Intl.NumberFormat('id-ID').format(item.harga);
                
                const row = `
                    <tr>
                        <td>${item.nama}</td>
                        <td class="text-center">${item.qty}</td>
                        <td class="text-end">Rp ${hargaFormatted}</td>
                    </tr>
                `;
                detailItemsBody.innerHTML += row;
            });
        } else {
            detailItemsBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Tidak ada data item.</td></tr>';
        }

        // Logika Tampilan Tombol Konfirmasi
        if (status === 'menunggu_pembayaran') {
            formKonfirmasiDetail.style.display = 'block';
            // Pastikan URL sesuai dengan route Anda
            formKonfirmasiDetail.action = `/admin/pemesananOnline/${orderId}/konfirmasi`; 
        } else {
            formKonfirmasiDetail.style.display = 'none';
        }
      });
    });
  </script>
@endsection