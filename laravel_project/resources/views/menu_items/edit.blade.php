@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Menu Item</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('menu_items.update', $menuItem->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $menuItem->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('kategori_id', $menuItem->kategori_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $menuItem->deskripsi) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $menuItem->harga) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            @if($menuItem->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$menuItem->gambar) }}" alt="Gambar" width="80">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="tersedia" {{ old('status', $menuItem->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="tidak tersedia" {{ old('status', $menuItem->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok <span class="text-muted">(opsional)</span></label>
                            <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $menuItem->stok) }}">
                        </div>
                        <div class="mb-3">
                            <label for="promo_aktif" class="form-label">Promo Aktif</label>
                            <select class="form-control" id="promo_aktif" name="promo_aktif" required>
                                <option value="aktif" {{ (old('promo_aktif', $menuItem->promo_aktif ?? '') == 'aktif') ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ (old('promo_aktif', $menuItem->promo_aktif ?? '') == 'tidak_aktif') ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <small class="text-muted">Pilih status promosi untuk menu ini.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('menu_items.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 