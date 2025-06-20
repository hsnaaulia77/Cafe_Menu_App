@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #4f46e5;
        --primary-hover: #4338ca;
        --success: #10b981;
        --danger: #ef4444;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-500: #6c757d;
        --gray-700: #495057;
        --gray-900: #212529;
        --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        --rounded-sm: 0.25rem;
        --rounded-md: 0.5rem;
        --rounded-lg: 0.75rem;
        --rounded-xl: 1rem;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: var(--rounded-xl) var(--rounded-xl) 0 0;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-body {
        padding: 2rem;
        background-color: white;
        border-radius: 0 0 var(--rounded-xl) var(--rounded-xl);
        box-shadow: var(--shadow-lg);
    }

    .form-section {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--gray-700);
        font-size: 0.95rem;
    }

    .required {
        color: var(--danger);
        margin-left: 0.25rem;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.625rem 0.875rem;
        font-size: 0.95rem;
        line-height: 1.5;
        color: var(--gray-900);
        background-color: white;
        background-clip: padding-box;
        border: 1px solid var(--gray-200);
        border-radius: var(--rounded-md);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
    }

    .form-control.is-valid {
        border-color: var(--success);
    }

    .error-text {
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0.625rem 0.875rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--gray-700);
        background-color: var(--gray-100);
        border: 1px solid var(--gray-200);
        border-radius: var(--rounded-md) 0 0 var(--rounded-md);
    }

    .input-group input {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        min-width: 0;
        border-radius: 0 var(--rounded-md) var(--rounded-md) 0 !important;
    }

    .upload-area {
        border: 2px dashed var(--gray-200);
        border-radius: var(--rounded-md);
        padding: 2rem 1rem;
        text-align: center;
        color: var(--gray-500);
        cursor: pointer;
        transition: all 0.2s ease;
        background-color: var(--gray-100);
        position: relative;
        margin-bottom: 0.5rem;
    }

    .upload-area:hover {
        border-color: var(--primary);
        background-color: rgba(79, 70, 229, 0.05);
    }

    .upload-area.dragover {
        border-color: var(--primary);
        background-color: rgba(79, 70, 229, 0.1);
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        margin-bottom: 1rem;
        color: var(--gray-500);
    }

    .upload-area.dragover .upload-icon {
        color: var(--primary);
    }

    .img-preview {
        margin-top: 1rem;
        max-width: 200px;
        border-radius: var(--rounded-sm);
        display: block;
        margin-left: auto;
        margin-right: auto;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .status-toggle {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.5rem;
    }

    .status-radio {
        position: absolute;
        opacity: 0;
    }

    .status-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-weight: 500;
        color: var(--gray-700);
    }

    .status-indicator {
        width: 18px;
        height: 18px;
        border: 2px solid var(--gray-500);
        border-radius: 50%;
        position: relative;
        transition: all 0.2s ease;
    }

    .status-radio:checked + .status-label .status-indicator {
        border-color: var(--primary);
    }

    .status-radio:checked + .status-label .status-indicator::after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: var(--primary);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: var(--rounded-md);
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-icon {
        width: 20px;
        height: 20px;
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem;
        }
        
        .status-toggle {
            flex-direction: column;
            gap: 0.75rem;
        }
    }

    .form-section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #8B4513; /* warna coklat */
        margin-bottom: 1.5rem;
        letter-spacing: 0.5px;
        text-align: center; /* posisi tengah */
        width: 100%;
        display: block;
    }

    .center-page-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: inherit; /* agar warna background tetap mengikuti theme */
    }
</style>

<div class="center-page-container">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-header bg-white border-0 rounded-top-4">
                        <span class="form-section-title">
                            {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <form id="menuForm" action="{{ isset($menu) ? route('menus.update', $menu->id) : route('menus.store') }}" method="POST" enctype="multipart/form-data" novalidate autocomplete="off">
                            @csrf
                            @if(isset($menu))
                                @method('PUT')
                            @endif

                            <!-- Nama Menu -->
                            <div class="form-section">
                                <label for="nama" class="form-label">Nama Menu<span class="required">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $menu->nama ?? '') }}" required placeholder="Contoh: Nasi Goreng Special">
                                <div class="error-text" id="namaError" style="display:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                    Nama menu wajib diisi
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-section">
                                <label for="deskripsi" class="form-label">Deskripsi<span class="required">*</span></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required placeholder="Deskripsikan menu secara detail">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
                                <div class="error-text" id="deskripsiError" style="display:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                    Deskripsi wajib diisi
                                </div>
                            </div>

                            <!-- Harga & Kategori -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-section">
                                        <label for="harga" class="form-label">Harga<span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', $menu->harga ?? '') }}" required placeholder="0" inputmode="numeric">
                                        </div>
                                        <div class="error-text" id="hargaError" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                            </svg>
                                            Harga wajib diisi dan harus angka
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-section">
                                        <label for="kategori" class="form-label">Kategori<span class="required">*</span></label>
                                        <select class="form-control" id="kategori" name="kategori" required>
                                            <option value="" disabled {{ old('kategori', $menu->kategori ?? '') == '' ? 'selected' : '' }}>Pilih kategori</option>
                                            <option value="Makanan" {{ (old('kategori', $menu->kategori ?? '') == 'Makanan') ? 'selected' : '' }}>Makanan</option>
                                            <option value="Minuman" {{ (old('kategori', $menu->kategori ?? '') == 'Minuman') ? 'selected' : '' }}>Minuman</option>
                                            <option value="Snack" {{ (old('kategori', $menu->kategori ?? '') == 'Snack') ? 'selected' : '' }}>Snack</option>
                                        </select>
                                        <div class="error-text" id="kategoriError" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                            </svg>
                                            Kategori wajib dipilih
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Gambar -->
                            <div class="form-section">
                                <label class="form-label">Upload Gambar</label>
                                <div id="uploadArea" class="upload-area">
                                    <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p>Drag & drop gambar di sini atau <span style="color: var(--primary); text-decoration: underline;">klik untuk memilih</span></p>
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                                    <input type="file" id="gambar" name="gambar" accept="image/*" style="display:none;">
                                    <img id="imgPreview" class="img-preview" style="display:none;">
                                    @if(isset($menu) && $menu->gambar)
                                        <img src="{{ asset('storage/' . $menu->gambar) }}" class="img-preview" style="display:block;">
                                    @endif
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-section">
                                <label class="form-label">Status<span class="required">*</span></label>
                                <div class="status-toggle">
                                    <input type="radio" id="statusTersedia" name="status" value="Tersedia" class="status-radio" {{ old('status', $menu->status ?? 'Tersedia') == 'Tersedia' ? 'checked' : '' }}>
                                    <label for="statusTersedia" class="status-label">
                                        <span class="status-indicator"></span>
                                        <span>Tersedia</span>
                                    </label>
                                    
                                    <input type="radio" id="statusTidakTersedia" name="status" value="Tidak tersedia" class="status-radio" {{ old('status', $menu->status ?? '') == 'Tidak tersedia' ? 'checked' : '' }}>
                                    <label for="statusTidakTersedia" class="status-label">
                                        <span class="status-indicator"></span>
                                        <span>Tidak Tersedia</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-section" style="margin-top: 2rem;">
                                <button type="submit" class="btn-primary">
                                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ isset($menu) ? 'Simpan Perubahan' : 'Tambah Menu' }}
                                </button>
                            </div>
                        </form>
                        
                        @if(isset($menu))
                            <form id="delete-form" action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Drag & drop area
    const uploadArea = document.getElementById('uploadArea');
    const gambarInput = document.getElementById('gambar');
    const imgPreview = document.getElementById('imgPreview');

    uploadArea.addEventListener('click', () => gambarInput.click());
    uploadArea.addEventListener('dragover', e => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
    uploadArea.addEventListener('drop', e => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        gambarInput.files = e.dataTransfer.files;
        showPreview();
    });
    gambarInput.addEventListener('change', showPreview);

    function showPreview() {
        const file = gambarInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Real-time validation & auto-format harga
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('menuForm');
        const nama = document.getElementById('nama');
        const deskripsi = document.getElementById('deskripsi');
        const harga = document.getElementById('harga');
        const kategori = document.getElementById('kategori');

        nama.addEventListener('input', function () {
            if (nama.value.trim() === '') {
                nama.classList.add('is-invalid');
                document.getElementById('namaError').style.display = 'flex';
            } else {
                nama.classList.remove('is-invalid');
                nama.classList.add('is-valid');
                document.getElementById('namaError').style.display = 'none';
            }
        });

        deskripsi.addEventListener('input', function () {
            if (deskripsi.value.trim() === '') {
                deskripsi.classList.add('is-invalid');
                document.getElementById('deskripsiError').style.display = 'flex';
            } else {
                deskripsi.classList.remove('is-invalid');
                deskripsi.classList.add('is-valid');
                document.getElementById('deskripsiError').style.display = 'none';
            }
        });

        harga.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString('id-ID');
            } else {
                e.target.value = '';
            }
            if (value === '' || isNaN(value)) {
                harga.classList.add('is-invalid');
                document.getElementById('hargaError').style.display = 'flex';
            } else {
                harga.classList.remove('is-invalid');
                harga.classList.add('is-valid');
                document.getElementById('hargaError').style.display = 'none';
            }
        });

        kategori.addEventListener('change', function () {
            if (kategori.value === '') {
                kategori.classList.add('is-invalid');
                document.getElementById('kategoriError').style.display = 'flex';
            } else {
                kategori.classList.remove('is-invalid');
                kategori.classList.add('is-valid');
                document.getElementById('kategoriError').style.display = 'none';
            }
        });

        form.addEventListener('submit', function (event) {
            let valid = true;
            if (nama.value.trim() === '') {
                nama.classList.add('is-invalid');
                document.getElementById('namaError').style.display = 'flex';
                valid = false;
            }
            if (deskripsi.value.trim() === '') {
                deskripsi.classList.add('is-invalid');
                document.getElementById('deskripsiError').style.display = 'flex';
                valid = false;
            }
            if (harga.value.trim() === '' || isNaN(harga.value.replace(/\D/g, ''))) {
                harga.classList.add('is-invalid');
                document.getElementById('hargaError').style.display = 'flex';
                valid = false;
            }
            if (kategori.value === '') {
                kategori.classList.add('is-invalid');
                document.getElementById('kategoriError').style.display = 'flex';
                valid = false;
            }
            if (!valid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
</script>
@endsection