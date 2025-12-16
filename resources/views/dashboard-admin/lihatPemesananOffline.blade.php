@extends('templates.sidebar-admin')

@section('title', 'Daftar Pemesanan Offline')

@section('content')
    <main class="content" id="content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Riwayat Pemesanan Offline</h4>
                <a href='/admin/pemesanan-offline/buat' class="btn btn-theme">
                    <i class="bi bi-plus-lg"></i> Buat Pesanan Baru
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Metode Bayar</th>
                                    <th>Total Nota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesanan as $p)
                                    <tr>
                                        <td>{{ $loop->iteration + $pesanan->firstItem() - 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggalPemesanan)->format('d M Y') }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $p->namaPelanggan }}</div>
                                            <small class="text-muted">{{ $p->noTelpPelanggan }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark text-capitalize">
                                                {{ $p->metodePembayaran }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($p->totalNota, 0, ',', '.') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada data transaksi offline.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $pesanan->links() }}
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection