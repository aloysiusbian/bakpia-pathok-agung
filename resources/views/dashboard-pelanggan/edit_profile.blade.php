@extends('templates.sidebar')

@section('title', 'Edit Profil')

@section('content')
<style>input::placeholder{
    font-style: italic;}
    #map {
        width: 100%;
        height: 400px;
        border-radius: 12px;
        border: 2px solid #ddd;
        z-index: 1;
        cursor: crosshair;
    }
    
    /* Tombol GPS Melayang */
    .btn-gps {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1000; /* Di atas peta */
        background: white;
        border: 2px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: 0.2s;
    }
    .btn-gps:hover {
        background: #f8f9fa;
        color: #0d6efd;
    }
    /* Biar input yang sedang loading kelihatan */
    .loading-field {
        background-color: #e9ecef;
        cursor: wait;
    }
    </style>
{{-- LEAFLET CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.css" />

{{-- LEAFLET JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.umd.js"></script>
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

            @php
            $primaryAddress = $primaryAddress ?? null;
            $label = $primaryAddress->judul_alamat ?? 'Rumah';
            @endphp

            {{-- FORM START: enctype wajib ada untuk upload file --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ========================================== --}}
                {{-- BAGIAN FOTO PROFIL (SUDAH DIPERBAIKI) --}}
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
                        <input type="file" class="form-control" name="foto_profil" id="foto_profil"
                               onchange="previewImage()">
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
                               placeholder="Nama Penerima..." required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon Penerima</label>
                        <input type="text" class="form-control"
                               name="address[noTelp]"
                               value="{{ $primaryAddress->no_telp_penerima ?? Auth::user()->noTelp ?? '' }}"
                               required>
                    </div>
                </div><hr class="my-4">
{{-- PETA --}}
                <div class="mb-4 position-relative">
                    <label class="form-label fw-bold text-success mb-2"><i class="bi bi-pin-map-fill"></i> Tentukan Titik Lokasi</label>
                    <p class="text-muted small mb-2">Geser pin untuk mengisi alamat otomatis. Anda tetap bisa mengubahnya secara manual di bawah.</p>
                    
                    <div style="position: relative;">
                        <div id="map"></div>
                        <button type="button" id="btn-gps" class="btn-gps" title="Lokasi Saya">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> Lokasi Saya
                        </button>
                    </div>
                    
                    {{-- Loading --}}
                    <div id="loading-map" class="position-absolute top-50 start-50 translate-middle badge bg-dark p-3" style="display: none; z-index: 1001;">
                        <span class="spinner-border spinner-border-sm me-2"></span> Mendeteksi Alamat...
                    </div>
                </div>

                <hr class="my-4">


                <div class="mb-3">
                    <label class="form-label">Label Alamat</label>
                    <select class="form-select" name="address[labelAlamat]">
                        @php $label = $primaryAddress->judul_alamat ?? 'Rumah'; @endphp
                        <option value="Rumah" {{ $label=='Rumah' ? 'selected' : '' }}>Rumah</option>
                        <option value="Kantor" {{ $label=='Kantor' ? 'selected' : '' }}>Kantor</option>
                        <option value="Lainnya" {{ $label=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="row">
                    {{-- PROVINSI (DROPDOWN BIASA) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Provinsi</label>
                        <select class="form-select" id="provinsiSelect" name="address[provinsi_id]" required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov['id'] }}" @if(($primaryAddress->provinsi_id ?? null) == $prov['id']) selected @endif>
                                    {{ $prov['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="provinsiNama" name="address[provinsi_nama]" value="{{ $primaryAddress->provinsi_nama ?? '' }}">
                    </div>

                    {{-- KOTA (DROPDOWN BIASA) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kota / Kabupaten</label>
                        <select class="form-select" id="regencySelect" name="address[kota_id]" required>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                        </select>
                        <input type="hidden" id="kotaNama" name="address[kota_nama]" value="{{ $primaryAddress->kota_nama ?? '' }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kecamatan</label>
                        {{-- INPUT MANUAL (TIDAK READONLY) --}}
                        <input type="text" class="form-control" id="kecamatanInput" name="address[kecamatan]" 
                               value="{{ $primaryAddress->kecamatan ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode Pos</label>
                        {{-- INPUT MANUAL (TIDAK READONLY) --}}
                        <input type="text" class="form-control" id="kodePosInput" name="address[kodePos]" 
                               value="{{ $primaryAddress->kode_pos ?? '' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamatLengkapInput" rows="3" name="address[alamatLengkap]" required>{{ $primaryAddress->alamat_lengkap ?? '' }}</textarea>
                </div>

                <input type="hidden" name="address[latitude]" id="latInput">
                <input type="hidden" name="address[longitude]" id="lngInput">

                <hr>
                <div class="mb-3">
                    <label class="form-label">Password Validasi</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-warning px-4 text-white">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const provinsiSelect = document.getElementById('provinsiSelect');
    const regencySelect = document.getElementById('regencySelect');
    const provinsiNama = document.getElementById('provinsiNama');
    const kotaNama = document.getElementById('kotaNama');

    const savedProvId = "{{ $primaryAddress->provinsi_id ?? '' }}";
    const savedCityId = "{{ $primaryAddress->kota_id ?? '' }}";

    // ===============================================
    // 1. FUNGSI LOAD KOTA (DENGAN AUTO-SELECT)
    // ===============================================
    function loadRegencies(provinceId, selectedCityId = null, autoSelectName = null) {
        regencySelect.innerHTML = '<option value="">Sedang memuat...</option>';
        regencySelect.disabled = true;

        if (!provinceId) {
            regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
            regencySelect.disabled = false;
            return;
        }

        fetch(`{{ route('api.regencies') }}?province_id=${provinceId}`)
            .then(response => response.json())
            .then(data => {
                regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                
                data.forEach(function (reg) {
                    const opt = document.createElement('option');
                    opt.value = reg.id;
                    opt.textContent = reg.name;
                    
                    // Logic Auto Select berdasarkan ID (Data Saved)
                    if (selectedCityId && selectedCityId == reg.id) {
                        opt.selected = true;
                        kotaNama.value = reg.name;
                    }
                    regencySelect.appendChild(opt);
                });

                regencySelect.disabled = false;

                // Logic Auto Select berdasarkan NAMA (Dari Peta)
                // Kita jalankan setelah dropdown terisi penuh
                if(autoSelectName) {
                    matchDropdownByName(regencySelect, autoSelectName, 'kota');
                }
            })
            .catch(err => {
                console.error(err);
                regencySelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    }

    // Event Listeners Manual
    provinsiSelect.addEventListener('change', function () {
        const text = this.options[this.selectedIndex].text;
        provinsiNama.value = this.value ? text : '';
        kotaNama.value = '';
        loadRegencies(this.value);
    });

    regencySelect.addEventListener('change', function () {
        const text = this.options[this.selectedIndex].text;
        kotaNama.value = this.value ? text : '';
    });

    // Load awal jika edit
    if(savedProvId) loadRegencies(savedProvId, savedCityId);


    // ===============================================
    // 2. SETUP PETA LEAFLET
    // ===============================================
    const defaultLat = {{ $primaryAddress->latitude ?? -6.200000 }};
    const defaultLng = {{ $primaryAddress->longitude ?? 106.816666 }};
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: 'OpenStreetMap', maxZoom: 19 }).addTo(map);
    const marker = L.marker([defaultLat, defaultLng], { draggable: true, autoPan: true }).addTo(map);

    marker.on('dragend', function (e) { getAddressFromCoordinates(marker.getLatLng().lat, marker.getLatLng().lng); });
    map.on('click', function (e) { marker.setLatLng(e.latlng); getAddressFromCoordinates(e.latlng.lat, e.latlng.lng); });

    // Tombol GPS
    const btnGps = document.getElementById('btn-gps');
    btnGps.addEventListener('click', function() {
        const originalText = btnGps.innerHTML;
        btnGps.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        btnGps.disabled = true;
        map.locate({setView: true, maxZoom: 16, enableHighAccuracy: true});
        
        map.once('locationfound', function(e) {
            btnGps.innerHTML = originalText; btnGps.disabled = false;
            marker.setLatLng(e.latlng);
            getAddressFromCoordinates(e.latlng.lat, e.latlng.lng);
        });
        map.once('locationerror', function() {
            btnGps.innerHTML = originalText; btnGps.disabled = false; alert("GPS Gagal / Ditolak.");
        });
    });


    // ===============================================
    // 3. LOGIKA DETEKSI ALAMAT (CORE)
    // ===============================================
    async function getAddressFromCoordinates(lat, lng) {
        document.getElementById('loading-map').style.display = 'block';
        document.getElementById('latInput').value = lat;
        document.getElementById('lngInput').value = lng;

        try {
            const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`;
            const response = await fetch(url);
            const data = await response.json();

            console.log("OSM Data:", data); // Debugging

            if (data && data.address) {
                const addr = data.address;

                // 1. Isi Text Input (Bebas diedit user)
                document.getElementById('kodePosInput').value = addr.postcode || '';
                const kec = addr.village || addr.suburb || addr.city_district || addr.town || '';
                document.getElementById('kecamatanInput').value = kec;
                
                let road = addr.road || '';
                let fullDetail = data.display_name; 
                // Format alamat singkat untuk input box
                if(road) fullDetail = `${road}, ${kec}`;
                document.getElementById('alamatLengkapInput').value = fullDetail;

                // 2. Deteksi Provinsi & Kota
                const provOSM = addr.state; 
                const cityOSM = addr.city || addr.regency || addr.county || addr.town; 

                if (provOSM) {
                    // Cari & Pilih Provinsi di Dropdown
                    const provFound = matchDropdownByName(provinsiSelect, provOSM, 'provinsi');
                    
                    if(provFound) {
                        // Jika provinsi ketemu, Load Kota
                        // KITA KIRIM NAMA KOTA KE FUNGSI LOAD, Biar dia yang pilih otomatis
                        loadRegencies(provinsiSelect.value, null, cityOSM);
                    }
                }
            }
        } catch (error) {
            console.error(error);
        } finally {
            document.getElementById('loading-map').style.display = 'none';
        }
    }

    // ===============================================
    // 4. HELPER MATCHING STRING (PINTAR)
    // ===============================================
    function matchDropdownByName(selectElement, searchName, type) {
        if (!searchName) return false;
        
        // Bersihkan string pencarian (Hapus "Provinsi", "Kota", "Kabupaten", spasi)
        const cleanSearch = searchName.toLowerCase()
            .replace('provinsi', '')
            .replace('daerah istimewa', '') // Kasus DIY
            .replace('di ', '') 
            .replace('kota', '')
            .replace('kabupaten', '')
            .trim();

        let bestMatchIndex = -1;

        for (let i = 0; i < selectElement.options.length; i++) {
            // Bersihkan text option di dropdown
            const optText = selectElement.options[i].text.toLowerCase()
                .replace('provinsi', '')
                .replace('daerah istimewa', '')
                .replace('di ', '')
                .replace('kota', '')
                .replace('kabupaten', '')
                .trim();

            // Cek apakah mengandung kata yang sama (Fuzzy Logic Sederhana)
            if (optText === cleanSearch || optText.includes(cleanSearch) || cleanSearch.includes(optText)) {
                bestMatchIndex = i;
                break; // Ketemu
            }
        }

        if (bestMatchIndex > 0) {
            selectElement.selectedIndex = bestMatchIndex;
            // Update hidden input manual karena event 'change' tidak trigger otomatis oleh JS
            if(type === 'provinsi') provinsiNama.value = selectElement.options[bestMatchIndex].text;
            if(type === 'kota') kotaNama.value = selectElement.options[bestMatchIndex].text;
            return true;
        }
        
        return false;
    }

});
</script>
@endsection