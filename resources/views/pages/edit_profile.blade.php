@extends('templates.sidebar')

@section('title', 'Edit Profil')

@section('content')

<div class="content" id="content">
    <div class="container">
        <div class="card p-4">

            <h4 class="fw-bold mb-4" style="color:#3a2d1a;">
                <i class="bi bi-person-lines-fill me-2"></i>Edit Profil
            </h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @php
                $primaryAddress = $primaryAddress ?? null;
                $label = $primaryAddress->judul_alamat ?? 'Rumah'; 
            @endphp

            {{-- FORM START: enctype wajib ada untuk upload file --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ========================================== --}}
                {{-- BAGIAN FOTO PROFIL (SUDAH DIPERBAIKI)      --}}
                {{-- ========================================== --}}
                <div class="row mb-4 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label d-block fw-bold text-center">Foto Saat Ini</label>
                        
                        {{-- Wrapper ini menjaga agar gambar tetap di tengah --}}
                        <div class="d-flex justify-content-center">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" 
                                     class="rounded-circle img-thumbnail d-block mx-auto" 
                                     width="100" height="100" 
                                     id="img-preview"
                                     style="object-fit: cover;"> 
                            @else
                                <img src="{{ asset('images/bian.png') }}" 
                                     class="rounded-circle img-thumbnail d-block mx-auto" 
                                     width="100" height="100" 
                                     id="img-preview"
                                     style="object-fit: cover;">
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <label class="form-label">Ganti Foto Profil</label>
                        <input type="file" class="form-control" name="foto_profil" id="foto_profil" onchange="previewImage()">
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                    </div>
                </div>

                <hr>

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
                        <input type="text" class="form-control"
                               name="address[namaPenerima]"
                               value="{{ $primaryAddress->nama_penerima ?? '' }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon Penerima</label>
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
                        <input type="text" class="form-control"
                               name="address[kodePos]"
                               value="{{ $primaryAddress->kode_pos ?? '' }}" required>
                    </div>
                </div>

                {{-- ALAMAT LENGKAP --}}
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" rows="3"
                              name="address[alamatLengkap]" required>{{ $primaryAddress->alamat_lengkap ?? '' }}</textarea>
                </div>

                {{-- CATATAN --}}
                <div class="mb-3">
                    <label class="form-label">Catatan untuk Kurir (Opsional)</label>
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
                    <button type="submit" class="btn btn-warning px-4 text-white">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
// SCRIPT PREVIEW IMAGE
function previewImage() {
    const image = document.querySelector('#foto_profil');
    const imgPreview = document.querySelector('#img-preview');

    // Kita tidak perlu display: block lagi karena sudah dihandle class Bootstrap (d-block)
    // Tapi untuk memastikan image muncul jika sebelumnya hidden:
    imgPreview.style.display = 'block'; 
    
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
}

// SCRIPT PROVINSI (TETAP SAMA)
document.addEventListener('DOMContentLoaded', function () {
    const provinsiSelect = document.getElementById('provinsiSelect');
    const regencySelect  = document.getElementById('regencySelect');
    const provinsiNama   = document.getElementById('provinsiNama');
    const kotaNama       = document.getElementById('kotaNama');

    const selectedProvinceId = provinsiSelect.value;
    const selectedRegencyId  = "{{ $primaryAddress->kota_id ?? '' }}";

    function loadRegencies(provinceId) {
        regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';

        if (!provinceId) return;
        
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