@extends('templates.sidebar')

@section('title', 'Riwayat Pemesanan')

@section('content')

<!-- CONTENT -->
<div class="content" id="content">
    <div class="card p-4">
        <h5 class="mb-3">Daftar Transaksi</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    {{-- <th>Kode Pesanan</th>  <-- DIHAPUS --}}
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($orders as $order)
                    @if ($order->statusPesanan === 'cancel')
                        @continue
                    @endif

                    @php
                        // Ambil produk pertama untuk ditampilkan
                        $firstDetail = $order->detailTransaksiOnline->first();
                        $namaProduk  = $firstDetail?->produk->namaProduk ?? '-';

                        // Jika pesanan punya lebih dari 1 produk, tampilkan info +x produk lain
                        if ($order->detailTransaksiOnline->count() > 1) {
                            $namaProduk .= ' (+' . ($order->detailTransaksiOnline->count() - 1) . ' produk lain)';
                        }

                        // Total qty
                        $totalQty = $order->detailTransaksiOnline->sum('jumlahBarang');

                        $statusLabel = ucfirst($order->statusPesanan);
                    @endphp

                    <tr>
                        {{-- Kolom kode pesanan dihapus --}}
                        {{-- <td>{{ $order->nomorPemesanan }}</td> --}}

                        <td>{{ \Carbon\Carbon::parse($order->tanggalPemesanan)->format('Y-m-d') }}</td>
                        <td>{{ $namaProduk }}</td>
                        <td>{{ $totalQty }}</td>
                        <td>Rp {{ number_format($order->totalNota, 0, ',', '.') }}</td>

                        <td>
                            @if ($order->statusPesanan === 'shipped')
                                <span class="status-selesai">
                                    <i class="bi bi-check-circle"></i> {{ $statusLabel }}
                                </span>
                            @elseif ($order->statusPesanan === 'pending' or $order->statusPesanan === 'payment')
                                <span class="status-proses">
                                    <i class="bi bi-hourglass-split"></i> {{ $statusLabel }}
                                </span>
                            @else
                                <span class="cancel">
                                    <i class="bi bi-x-circle"></i> {{ $statusLabel }}
                                </span>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada transaksi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const navbar  = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        navbar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });
</script>

@endsection
