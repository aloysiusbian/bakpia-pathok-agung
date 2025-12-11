@extends('templates.sidebar-admin')

@section('title', 'Edit Profil Admin')

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

            @error('current_password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- FORM START: enctype wajib ada untuk upload file --}}
            <form action="{{ route('admin.akun-admin.update') }}" method="POST" enctype="multipart/form-data">
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
                            @if(Auth::user()->image)
                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                 class="rounded-circle img-thumbnail d-block mx-auto"
                                 width="100" height="100"
                                 id="img-preview"
                                 style="object-fit: cover;">
                            @else
                            <img src="{{ asset('images/profile-dummy.png') }}"
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
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username"
                           value="{{ Auth::user()->username ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" name="email"
                           value="{{ Auth::user()->email ?? '' }}" required>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label">Password Validasi</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>

                <hr class="my-4">

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
