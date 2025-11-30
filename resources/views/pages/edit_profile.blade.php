@extends('templates.sidebar')

@section('title', 'Edit Profil')

@section('content')

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
                            <option value="Rumah" {{ $label==
                            'Rumah' ? 'selected' : '' }}>Rumah</option>
                            <option value="Kantor" {{ $label==
                            'Kantor' ? 'selected' : '' }}>Kantor</option>
                            <option value="Lainnya" {{ $label==
                            'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                              name="address[alamatLengkap]"
                              required>{{ $primaryAddress['alamatLengkap'] ?? '' }}</textarea>
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

@endsection
