@extends('layouts.app')

@section('title', isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-utensils"></i> {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('menus.index') }}" class="btn btn-tool">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <form id="menuForm" action="{{ isset($menu) ? route('menus.update', $menu->id) : route('menus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($menu))
                            @method('PUT')
                        @endif

                <div class="card-body">
                        <!-- Nama Menu -->
                    <div class="form-group">
                        <label for="nama">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $menu->nama ?? '') }}" placeholder="Contoh: Nasi Goreng Special" required>
                        @error('nama')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        </div>

                        <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsikan menu secara detail" required>{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        </div>

                        <!-- Harga & Kategori -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                    <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $menu->harga ?? '') }}" placeholder="0" required>
                                </div>
                                @error('harga')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                    <option value="" disabled {{ old('kategori', $menu->kategori ?? '') == '' ? 'selected' : '' }}>Pilih kategori</option>
                                    <option value="Makanan" {{ (old('kategori', $menu->kategori ?? '') == 'Makanan') ? 'selected' : '' }}>Makanan</option>
                                    <option value="Minuman" {{ (old('kategori', $menu->kategori ?? '') == 'Minuman') ? 'selected' : '' }}>Minuman</option>
                                    <option value="Snack" {{ (old('kategori', $menu->kategori ?? '') == 'Snack') ? 'selected' : '' }}>Snack</option>
                                </select>
                                @error('kategori')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Upload Gambar -->
                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                            <label class="custom-file-label" for="gambar">Pilih file gambar</label>
                        </div>
                        <small class="form-text text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                        @error('gambar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        
                        <!-- Preview Gambar -->
                        <div class="mt-3" id="imagePreview" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                                @if(isset($menu) && $menu->gambar)
                            <div class="mt-3">
                                <label>Gambar Saat Ini:</label>
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        @endif
                        </div>

                        <!-- Status -->
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status_tersedia" name="status" value="Tersedia" class="custom-control-input" {{ old('status', $menu->status ?? 'Tersedia') == 'Tersedia' ? 'checked' : '' }} required>
                            <label class="custom-control-label" for="status_tersedia">Tersedia</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status_tidak" name="status" value="Tidak tersedia" class="custom-control-input" {{ old('status', $menu->status ?? '') == 'Tidak tersedia' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="status_tidak">Tidak Tersedia</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                            </div>
                        </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        @if(isset($menu))
                            <button type="button" class="btn btn-danger" onclick="deleteMenu()">
                                <i class="fas fa-trash"></i> Hapus Menu
                            </button>
                        @else
                            <div></div>
                        @endif
                        <div>
                            <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($menu) ? 'Update Menu' : 'Simpan Menu' }}
                            </button>
                        </div>
                    </div>
                        </div>
                    </form>
        </div>
    </div>
</div>

                    @if(isset($menu))
                        <form id="delete-form" action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif

<script>
// Preview gambar
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const label = document.querySelector('.custom-file-label');
    
        if (file) {
        label.textContent = file.name;
            const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
            reader.readAsDataURL(file);
            } else {
        label.textContent = 'Pilih file gambar';
        preview.style.display = 'none';
            }
        });

// Format harga
document.getElementById('harga').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString('id-ID');
    }
});

// Hapus menu
function deleteMenu() {
    if (confirm('Yakin ingin menghapus menu ini?')) {
        document.getElementById('delete-form').submit();
            }
}
</script>
@endsection