@extends('templates.daftar-pesanan')

@section('title', 'Pesanan Saya')

@section('content-pesanan')
<div class="orders-container-box">

    @php
        $orders       = $orders ?? collect();
        // kalau lupa dikirim dari controller, fallback ke query string
        $filterStatus = $filterStatus ?? request('status');
    @endphp

    @forelse($orders as $order)
        <div class="transaction-card"
             onclick="window.location.href='{{ route('pesanan.detail', $order->nomorPemesanan) }}'">

            {{-- Tanggal + Status --}}
            <div class="transaction-date">
                {{ \Carbon\Carbon::parse($order->tanggalPemesanan)->format('d-m-Y') }}
                |
                @php
                    $status      = strtolower($order->statusPesanan);
                    $statusClass = in_array($status, ['batal', 'dibatalkan'])
                        ? 'status-badge-cancel'
                        : 'status-badge';
                @endphp
                <span class="{{ $statusClass }}">{{ ucfirst($status) }}</span>
            </div>

            {{-- Produk --}}
            @foreach($order->detailTransaksiOnline as $detail)
                @php $produk = $detail->produk; @endphp

                <div class="product-item">
                    <img src="{{ $produk ? asset('images/' . $produk->gambar) : asset('images/bakpia-default.jpg') }}"
                         alt="{{ $produk->namaProduk ?? 'Produk' }}"
                         class="product-img"
                         onerror="this.src='{{ asset('images/bakpia-default.jpg') }}'">

                    <div class="product-info">
                        <div class="product-name">{{ $produk->namaProduk ?? '-' }}</div>
                        <div class="product-variant">
                            Variasi : {{ $produk->pilihanJenis ?? '1 box isi 15' }}
                        </div>
                        <div class="product-variant">x{{ $detail->jumlahBarang }}</div>
                    </div>
                </div>
            @endforeach

            {{-- Total --}}
            <div class="total-section {{ $order->detailTransaksiOnline->count() > 1 ? 'border-top pt-3' : '' }}">
                <span class="total-label">Total Pesanan :</span>
                <span class="total-amount">
                    Rp {{ number_format($order->totalNota, 0, ',', '.') }}
                </span>
            </div>

    
            {{-- Tombol Aksi --}}
            <div class="action-buttons" style="margin-top: 15px; display: flex; gap: 10px; justify-content: flex-end;">
                
                @if($status === 'menunggu_pembayaran')
                    {{-- TOMBOL BATAL --}}
                    <form action="{{ route('pesanan.batal', $order->nomorPemesanan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                onclick="event.stopPropagation()">
                            Batalkan
                        </button>
                    </form>

                    {{-- TOMBOL BAYAR --}}
                    @php
                        // Logika penentuan route pembayaran
                        // Asumsi: nilai metodePembayaran di database adalah 'QRIS' atau 'Transfer Bank' (sesuaikan stringnya)
                        $routeBayar = '#';
                        if (str_contains(strtolower($order->metodePembayaran), 'qris')) {
                            $routeBayar = route('pembayaran.qris', $order->nomorPemesanan);
                        } else {
                            // Default ke Bank / Transfer
                            $routeBayar = route('pembayaran.bank', $order->nomorPemesanan);
                        }
                    @endphp

                    <a href="{{ $routeBayar }}" class="btn btn-success btn-sm" onclick="event.stopPropagation()">
                        Bayar Sekarang
                    </a>

                @elseif($filterStatus === 'selesai' || $status === 'selesai')
                    {{-- TOMBOL SELESAI (Rating/Beli Lagi) --}}
                    <button class="btn btn-custom-gray" onclick="event.stopPropagation()">
                        Beri Rating
                    </button>
                    <button class="btn btn-custom-gray" onclick="event.stopPropagation()">
                        Beli Lagi
                    </button>
                @endif
        </div>
    @empty
        <div class="text-center py-5">
            <h5 class="text-muted">Belum ada pesanan untuk status ini.</h5>
        </div>
    @endforelse

</div>
@endsection
