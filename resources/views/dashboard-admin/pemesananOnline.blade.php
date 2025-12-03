@extends('templates.sidebar-admin')

@section('title', 'Pemesanan Online')

@section('content')

  <main class="content" id="content">
    <div class="container-fluid">

      <!-- RINGKASAN STATISTIK -->
      {{-- Mengakses variabel $summary yang dihitung di Controller --}}
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

      <!-- FILTER & JUDUL -->
      <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <div>
          <h4 class="mb-0">Daftar Pemesanan Online</h4>
          <small class="text-muted">Kelola pesanan yang masuk melalui website / aplikasi.</small>
        </div>
        <div class="d-flex gap-2">
          <div class="filter-select input-group input-group-sm" style="width: 180px;">
            <span class="input-group-text"><i class="bi bi-sliders"></i></span>
            <select class="form-select">
              <option>Semua Status</option>
              <option>Menunggu Pembayaran</option>
              <option>Sudah Dibayar</option>
              <option>Dibatalkan</option>
            </select>
          </div>
          <div class="filter-select input-group input-group-sm" style="width: 160px;">
            <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
            <select class="form-select">
              <option>Semua Metode</option>
              <option>Transfer Bank</option>
              <option>COD</option>
              <option>QRIS</option>
            </select>
          </div>
        </div>
      </div>

      <div class="card shadow-lg border-0">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group input-group-sm" style="max-width: 260px;">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Cari ID / nama pelanggan">
            </div>
            {{-- Menampilkan informasi pagination dari $orders --}}
            <small class="text-muted">Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} dari
              {{ $orders->total() ?? 0 }} pesanan</small>
          </div>

          <!-- TABEL DINAMIS PEMESANAN -->
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
                    {{-- Menggunakan nomorPemesanan (UUID) --}}
                    <td><span class="fw-semibold">{{ $order->nomorPemesanan }}</span></td>
                    <td>
                      @php
                        // Menggunakan kolom 'statusPesanan' dari skema database
                        $status = $order->statusPesanan ?? 'Dibatalkan';
                        $statusClass = [
                          'Menunggu Pembayaran' => 'bg-warning text-dark',
                          'Sudah Dibayar' => 'bg-success',
                          'Dibatalkan' => 'bg-danger',
                        ][$status] ?? 'bg-secondary';

                        $statusIcon = [
                          'Menunggu Pembayaran' => 'bi-hourglass-split',
                          'Sudah Dibayar' => 'bi-check-circle',
                          'Dibatalkan' => 'bi-x-circle',
                        ][$status] ?? 'bi-question-circle';
                      @endphp

                      <span class="badge {{ $statusClass }} badge-status">
                        <i class="bi {{ $statusIcon }} me-1"></i>{{ $status }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm" role="group">
                        {{-- Tombol Detail - Data disesuaikan dengan skema database --}}
                        <button class="btn btn-outline-dark btn-detail" data-bs-toggle="modal"
                          data-bs-target="#modalDetailPesanan" data-orderid="{{ $order->nomorPemesanan }}"
                          data-nama="{{ $order->pelanggan->namaPelanggan ?? 'Nama Tidak Tersedia' }}"
                          data-alamat="{{ $order->alamatPengirim }}" data-hp="{{ $order->pelanggan->nomorHP ?? '-' }}"
                          data-metode="{{ $order->metodePembayaran }}"
                          data-total="Rp {{ number_format($order->totalNota, 0, ',', '.') }}"
                          data-tgl="{{ \Carbon\Carbon::parse($order->tanggalPemesanan)->format('d M Y') }}"
                          data-status="{{ $order->statusPesanan }}">
                          <i class="bi bi-eye"></i> Detail
                        </button>

                        {{-- Tombol Bukti Transfer (Asumsi kolom buktiPembayaran ada) --}}
                        @if ($order->buktiPembayaran ?? false)
                          <button class="btn btn-outline-primary btn-lihat-bukti" data-bs-toggle="modal"
                            data-bs-target="#modalBuktiTransfer" data-bukti="{{ asset($order->buktiPembayaran) }}">
                            <i class="bi bi-file-earmark-image"></i> Bukti
                          </button>
                        @else
                          <button class="btn btn-outline-secondary" disabled>
                            <i class="bi bi-file-earmark-image"></i> Tidak ada bukti
                          </button>
                        @endif

                        {{-- Tombol Konfirmasi --}}
                        @if ($order->statusPesanan == 'Menunggu Pembayaran')
                          <button class="btn btn-success btn-konfirmasi" data-bs-toggle="modal"
                            data-bs-target="#modalKonfirmasiPembayaran" data-orderid="{{ $order->nomorPemesanan }}">
                            <i class="bi bi-check2-circle"></i> Konfirmasi
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">
                      Tidak ada pesanan yang ditemukan.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          @if(isset($orders) && method_exists($orders, 'links'))
            <nav aria-label="Page navigation" class="mt-4">
              {{-- Menggunakan Blade component untuk pagination --}}
              {{ $orders->links('pagination::bootstrap-5') }}
            </nav>
          @endif

        </div>
      </div>
    </div>
  </main>

  <!-- MODAL LIHAT BUKTI -->
  <div class="modal fade" id="modalBuktiTransfer" tabindex="-1" aria-labelledby="modalBuktiTransferLabel"
    aria-hidden="true">
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
          {{-- Form untuk Konfirmasi Pembayaran --}}
          <form id="konfirmasiForm" method="POST" action="">
            @csrf
            <input type="hidden" name="order_id" id="konfirmasiOrderId">
            <p class="text-danger small mt-2">Tindakan ini tidak dapat dibatalkan.</p>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-success" type="submit" form="konfirmasiForm">Ya, Konfirmasi</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL DETAIL PESANAN -->
  <div class="modal fade" id="modalDetailPesanan" tabindex="-1" aria-labelledby="modalDetailPesananLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailPesananLabel">Detail Pesanan</h5>
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
              <p class="mb-1"><strong>Total:</strong> <span id="detailTotal" class="fw-bold text-lg text-primary"></span>
              </p>
              <p class="mb-1"><strong>Status Pembayaran:</strong> <span id="detailStatus" class="fw-semibold"></span></p>
            </div>
          </div>

          <h6 class="mt-4 mb-3 border-bottom pb-1">Item Pesanan</h6>
          {{-- Bagian ini memerlukan loop foreach terpisah untuk PemesananDetail (belum ada di skema) --}}
          <table class="table table-sm table-bordered">
            <thead>
              <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga Satuan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="3" class="text-center text-muted">Data item pesanan dimuat melalui JavaScript atau Blade
                  Component.</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <style>
    /* Style kustom untuk badge status */
    .badge-status {
      padding: 5px 10px;
      border-radius: 12px;
      font-size: 0.85rem;
    }

    /* Style kustom untuk card summary */
    .summary-card {
      transition: transform 0.2s;
      border: none;
      /* Menghilangkan border default card bootstrap */
    }

    .summary-card:hover {
      transform: translateY(-3px);
    }

    /* Style untuk filter select dengan icon */
    .filter-select .input-group-text {
      background-color: #fff;
      border-right: none;
    }

    .filter-select .form-select {
      border-left: none;
    }
  </style>

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
@endsection