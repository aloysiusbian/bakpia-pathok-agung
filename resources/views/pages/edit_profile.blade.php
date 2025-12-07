@extends('templates.sidebar')

@section('title', 'Edit Profil')

@section('content')

<div class="content" id="content">
    <div class="container">
        <div class="card p-4">

            <h4 class="fw-bold mb-4" style="color:#3a2d1a;">
                <i class="bi bi-person-lines-fill me-2"></i>Edit Profil
            </h4>

            {{-- Pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @php
                // Pastikan $primaryAddress ada
                $primaryAddress = $primaryAddress ?? null;
                
                // PERBAIKAN 1: Akses menggunakan tanda panah (->) karena ini Object
                // PERBAIKAN 2: Gunakan nama kolom DB 'judul_alamat'
                $label = $primaryAddress->judul_alamat ?? 'Rumah'; 
            @endphp

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- DATA AKUN --}}
                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" name="email"
                           value="{{ Auth::user()->email ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Telepon Akun</label>
                    <input type="text" class="form-control" name="noTelp"
                           value="{{ Auth::user()->noTelp ?? '' }}">
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3" style="color:#3a2d1a;">Alamat Pengiriman Utama</h5>

                {{-- NAMA PENERIMA --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Penerima</label>
                        {{-- PERBAIKAN: $primaryAddress->nama_penerima --}}
                        <input type="text" class="form-control"
                               name="address[namaPenerima]"
                               value="{{ $primaryAddress->nama_penerima ?? '' }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon Penerima</label>
                        {{-- PERBAIKAN: Gunakan kolom DB 'no_telp_penerima' --}}
                        <input type="text" class="form-control"
                               name="address[noTelp]"
                               value="{{ $primaryAddress->no_telp_penerima ?? Auth::user()->noTelp ?? '' }}"
                               required>
                    </div>
                </div>

                {{-- LABEL ALAMAT + PROVINSI + KOTA --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Label Alamat</label>
                        <select class="form-select" name="address[labelAlamat]">
                            <option value="Rumah"   {{ $label=='Rumah' ? 'selected' : '' }}>Rumah</option>
                            <option value="Kantor"  {{ $label=='Kantor' ? 'selected' : '' }}>Kantor</option>
                            <option value="Lainnya" {{ $label=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    {{-- PROVINSI --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Provinsi</label>
                        <select class="form-select" id="provinsiSelect"
                                name="address[provinsi_id]" required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov['id'] }}"
                                    {{-- PERBAIKAN: Akses ->provinsi_id --}}
                                    @if(($primaryAddress->provinsi_id ?? null) == $prov['id']) selected @endif>
                                    {{ $prov['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="provinsiNama"
                               name="address[provinsi_nama]"
                               value="{{ $primaryAddress->provinsi_nama ?? '' }}">
                    </div>

                    {{-- KABUPATEN / KOTA --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kota / Kabupaten</label>
                        <select class="form-select" id="regencySelect"
                                name="address[kota_id]" required>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                        </select>

                        <input type="hidden" id="kotaNama"
                               name="address[kota_nama]"
                               value="{{ $primaryAddress->kota_nama ?? '' }}">
                    </div>
                </div>

                {{-- KECAMATAN + KODE POS --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" class="form-control"
                               name="address[kecamatan]"
                               value="{{ $primaryAddress->kecamatan ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Pos</label>
                        {{-- PERBAIKAN: Gunakan kolom DB 'kode_pos' --}}
                        <input type="text" class="form-control"
                               name="address[kodePos]"
                               value="{{ $primaryAddress->kode_pos ?? '' }}" required>
                    </div>
                </div>

                {{-- ALAMAT LENGKAP --}}
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    {{-- PERBAIKAN: Gunakan kolom DB 'alamat_lengkap' --}}
                    <textarea class="form-control" rows="3"
                              name="address[alamatLengkap]" required>{{ $primaryAddress->alamat_lengkap ?? '' }}</textarea>
                </div>

                {{-- CATATAN --}}
                <div class="mb-3">
                    <label class="form-label">Catatan untuk Kurir (Opsional)</label>
                    {{-- PERBAIKAN: Gunakan kolom DB 'catatan_kurir' --}}
                    <input type="text" class="form-control"
                           name="address[catatanKurir]"
                           value="{{ $primaryAddress->catatan_kurir ?? '' }}">
                </div>

                {{-- DEFAULT --}}
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox"
                           id="isDefault" name="address[isDefault]"
                           value="1" {{ ($primaryAddress->is_utama ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isDefault">
                        Jadikan sebagai alamat utama
                    </label>
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

{{-- ===================== --}}
{{-- SCRIPT PROVINSI / KOTA --}}
{{-- ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinsiSelect = document.getElementById('provinsiSelect');
    const regencySelect  = document.getElementById('regencySelect');
    const provinsiNama   = document.getElementById('provinsiNama');
    const kotaNama       = document.getElementById('kotaNama');

    const selectedProvinceId = provinsiSelect.value;
    // PERBAIKAN: Akses ->kota_id
    const selectedRegencyId  = "{{ $primaryAddress->kota_id ?? '' }}";

    function loadRegencies(provinceId) {
        regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';

        if (!provinceId) return;
        
        // PASTIKAN ROUTE INI BENAR SESUAI WEB.PHP ('profile.regencies' atau 'api.regencies')
        fetch(`{{ route('api.regencies') }}?province_id=${provinceId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(function (reg) {
                    const opt = document.createElement('option');
                    opt.value = reg.id;
                    opt.textContent = reg.name;

                    if (selectedRegencyId && selectedRegencyId == reg.id) {
                        opt.selected = true;
                        kotaNama.value = reg.name;
                    }

                    regencySelect.appendChild(opt);
                });
            });
    }

    if (selectedProvinceId) {
        loadRegencies(selectedProvinceId);
    }

    provinsiSelect.addEventListener('change', function () {
        const provinceId = this.value;
        const selectedText = this.options[this.selectedIndex].text;
        
        if (provinceId) {
             provinsiNama.value = selectedText;
        } else {
             provinsiNama.value = "";
        }
        
        kotaNama.value = '';
        loadRegencies(provinceId);
    });

    regencySelect.addEventListener('change', function () {
        const selectedText = this.options[this.selectedIndex].text;
        if(this.value) {
            kotaNama.value = selectedText;
        } else {
            kotaNama.value = "";
        }
    });
});
</script>

@endsection