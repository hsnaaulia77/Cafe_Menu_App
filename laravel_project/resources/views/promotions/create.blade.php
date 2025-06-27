@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Promosi Baru</h1>
    <form action="{{ route('promotions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Promo</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="kode_voucher" class="form-label">Kode Voucher (Opsional)</label>
            <input type="text" name="kode_voucher" id="kode_voucher" class="form-control" value="{{ old('kode_voucher') }}">
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="diskon_persen" class="form-label">Diskon (%)</label>
                <input type="number" name="diskon_persen" id="diskon_persen" class="form-control" min="0" max="100" value="{{ old('diskon_persen') }}">
            </div>
            <div class="col-md-6">
                <label for="potongan_harga" class="form-label">Potongan Harga (Rp)</label>
                <input type="number" name="potongan_harga" id="potongan_harga" class="form-control" min="0" value="{{ old('potongan_harga') }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
            </div>
            <div class="col-md-6">
                <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control" value="{{ old('tanggal_berakhir') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection 