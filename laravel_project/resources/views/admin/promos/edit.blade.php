@extends('layouts.app')

@section('title', 'Edit Promo')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Promo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.promos.index') }}">Promo & Kupon</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('admin.promos.update', $promo) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-coffee">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                Form Edit Promo
                            </h3>
                        </div>
                        
                        <div class="card-body">
                            <!-- Nama Promo -->
                            <div class="form-group">
                                <label for="nama">Nama Promo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama', $promo->nama) }}" 
                                       placeholder="Contoh: Diskon 20% Minuman" required>
                                @error('nama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3" 
                                          placeholder="Deskripsi detail promo">{{ old('deskripsi', $promo->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Promo -->
                            <div class="form-group">
                                <label for="jenis">Jenis Promo <span class="text-danger">*</span></label>
                                <select class="form-control @error('jenis') is-invalid @enderror" 
                                        id="jenis" name="jenis" required>
                                    <option value="" disabled>Pilih jenis promo</option>
                                    <option value="diskon_persen" {{ old('jenis', $promo->jenis) == 'diskon_persen' ? 'selected' : '' }}>
                                        Diskon Persentase
                                    </option>
                                    <option value="diskon_nominal" {{ old('jenis', $promo->jenis) == 'diskon_nominal' ? 'selected' : '' }}>
                                        Diskon Nominal
                                    </option>
                                    <option value="voucher" {{ old('jenis', $promo->jenis) == 'voucher' ? 'selected' : '' }}>
                                        Voucher/Kupon
                                    </option>
                                    <option value="bundle" {{ old('jenis', $promo->jenis) == 'bundle' ? 'selected' : '' }}>
                                        Promo Bundle
                                    </option>
                                </select>
                                @error('jenis')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nilai Promo -->
                            <div class="form-group">
                                <label for="nilai">Nilai Promo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="nilai_prefix">
                                            {{ $promo->jenis === 'diskon_persen' ? '' : 'Rp' }}
                                        </span>
                                    </div>
                                    <input type="number" class="form-control @error('nilai') is-invalid @enderror" 
                                           id="nilai" name="nilai" value="{{ old('nilai', $promo->nilai) }}" 
                                           placeholder="0" step="0.01" min="0" required>
                                </div>
                                <small class="form-text text-muted" id="nilai_help">
                                    {{ $promo->jenis === 'diskon_persen' ? 'Masukkan persentase diskon (contoh: 20 untuk 20%)' : 'Masukkan nilai diskon dalam rupiah' }}
                                </small>
                                @error('nilai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kode Kupon -->
                            <div class="form-group" id="kode_kupon_group" style="{{ $promo->jenis === 'voucher' ? 'display: block;' : 'display: none;' }}">
                                <label for="kode_kupon">Kode Kupon</label>
                                <input type="text" class="form-control @error('kode_kupon') is-invalid @enderror" 
                                       id="kode_kupon" name="kode_kupon" value="{{ old('kode_kupon', $promo->kode_kupon) }}" 
                                       placeholder="Kosongkan untuk generate otomatis">
                                <small class="form-text text-muted">
                                    Biarkan kosong untuk generate kode otomatis
                                </small>
                                @error('kode_kupon')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Minimum Pembelian -->
                            <div class="form-group">
                                <label for="minimum_pembelian">Minimum Pembelian</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control @error('minimum_pembelian') is-invalid @enderror" 
                                           id="minimum_pembelian" name="minimum_pembelian" 
                                           value="{{ old('minimum_pembelian', $promo->minimum_pembelian) }}" 
                                           placeholder="0" step="100" min="0">
                                </div>
                                <small class="form-text text-muted">
                                    Minimum pembelian untuk menggunakan promo (0 = tidak ada minimum)
                                </small>
                                @error('minimum_pembelian')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Maksimal Penggunaan -->
                            <div class="form-group">
                                <label for="maksimal_penggunaan">Maksimal Penggunaan</label>
                                <input type="number" class="form-control @error('maksimal_penggunaan') is-invalid @enderror" 
                                       id="maksimal_penggunaan" name="maksimal_penggunaan" 
                                       value="{{ old('maksimal_penggunaan', $promo->maksimal_penggunaan) }}" 
                                       placeholder="Kosongkan untuk unlimited" min="1">
                                <small class="form-text text-muted">
                                    Maksimal berapa kali promo bisa digunakan (kosongkan untuk unlimited)
                                </small>
                                @error('maksimal_penggunaan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Periode Promo -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                               id="tanggal_mulai" name="tanggal_mulai" 
                                               value="{{ old('tanggal_mulai', $promo->tanggal_mulai->format('Y-m-d')) }}" required>
                                        @error('tanggal_mulai')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_berakhir">Tanggal Berakhir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" 
                                               id="tanggal_berakhir" name="tanggal_berakhir" 
                                               value="{{ old('tanggal_berakhir', $promo->tanggal_berakhir->format('Y-m-d')) }}" required>
                                        @error('tanggal_berakhir')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Bundle -->
                            <div class="form-group" id="menu_bundle_group" style="{{ $promo->jenis === 'bundle' ? 'display: block;' : 'display: none;' }}">
                                <label>Pilih Menu untuk Bundle</label>
                                <div class="row">
                                    @foreach($menus as $menu)
                                    <div class="col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" 
                                                   id="menu_{{ $menu->id }}" name="menu_bundle[]" 
                                                   value="{{ $menu->id }}" 
                                                   {{ in_array($menu->id, old('menu_bundle', $promo->menu_bundle ?? [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="menu_{{ $menu->id }}">
                                                {{ $menu->nama }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    Pilih menu yang akan di-bundle
                                </small>
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="status_aktif" name="status" value="aktif" 
                                           class="custom-control-input" 
                                           {{ old('status', $promo->status) == 'aktif' ? 'checked' : '' }} required>
                                    <label class="custom-control-label" for="status_aktif">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="status_nonaktif" name="status" value="nonaktif" 
                                           class="custom-control-input" 
                                           {{ old('status', $promo->status) == 'nonaktif' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status_nonaktif">Nonaktif</label>
                                </div>
                                @error('status')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Promo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('jenis');
    const nilaiInput = document.getElementById('nilai');
    const nilaiPrefix = document.getElementById('nilai_prefix');
    const nilaiHelp = document.getElementById('nilai_help');
    const kodeKuponGroup = document.getElementById('kode_kupon_group');
    const menuBundleGroup = document.getElementById('menu_bundle_group');

    function updateFormFields() {
        const selectedJenis = jenisSelect.value;
        
        // Update nilai field
        if (selectedJenis === 'diskon_persen') {
            nilaiPrefix.textContent = '';
            nilaiHelp.textContent = 'Masukkan persentase diskon (contoh: 20 untuk 20%)';
            nilaiInput.placeholder = '20';
            nilaiInput.step = '1';
            nilaiInput.min = '0';
            nilaiInput.max = '100';
        } else {
            nilaiPrefix.textContent = 'Rp';
            nilaiHelp.textContent = 'Masukkan nilai diskon dalam rupiah';
            nilaiInput.placeholder = '10000';
            nilaiInput.step = '100';
            nilaiInput.min = '0';
            nilaiInput.removeAttribute('max');
        }

        // Show/hide kode kupon field
        if (selectedJenis === 'voucher') {
            kodeKuponGroup.style.display = 'block';
        } else {
            kodeKuponGroup.style.display = 'none';
        }

        // Show/hide menu bundle field
        if (selectedJenis === 'bundle') {
            menuBundleGroup.style.display = 'block';
        } else {
            menuBundleGroup.style.display = 'none';
        }
    }

    jenisSelect.addEventListener('change', updateFormFields);
    updateFormFields(); // Run on page load
});
</script>
@endpush
@endsection 