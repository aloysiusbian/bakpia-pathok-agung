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
                {{ \Carbon\Carbon::parse($order->tanggalPemesanan)->format('d-m-Y H:i') }}
                |
                @php
                    $status      = strtolower($order->statusPesanan);
                    $statusClass = in_array($status, ['cancel', 'dibatalkan'])
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

            {{-- Tombol Aksi: hanya muncul di tab "shipped" --}}
            @if($filterStatus === 'shipped')
                <div class="action-buttons">
                    <button class="btn btn-custom-gray" onclick="event.stopPropagation()">
                        Beri Rating
                    </button>
                    <button class="btn btn-custom-gray" onclick="event.stopPropagation()">
                        Beli Lagi
                    </button>
                </div>
            @endif
        </div>
    @empty
        <div class="text-center py-5">
            <h5 class="text-muted">Belum ada pesanan untuk status ini.</h5>
        </div>
    @endforelse

</div>
@endsection
