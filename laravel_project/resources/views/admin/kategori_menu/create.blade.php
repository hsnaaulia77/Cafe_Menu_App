@extends('layouts.app')

@section('title', 'Tambah Kategori Menu')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Kategori Menu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kategori_menu.index') }}">Kategori Menu</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-lg animate__animated animate__fadeInUp" style="border-radius: 18px;">
                <div class="card-header card-header-coffee" style="border-radius: 18px 18px 0 0;">
                    <h3 class="card-title mb-0"><i class="fas fa-plus mr-2"></i> Tambah Kategori Menu</h3>
                </div>
                <form action="{{ route('admin.kategori_menu.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label for="nama" class="form-label font-weight-bold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required autofocus style="border-radius:8px;">
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="deskripsi" class="form-label font-weight-bold">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" style="border-radius:8px;">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center" style="border-radius: 0 0 18px 18px;">
                        <a href="{{ route('admin.kategori_menu.index') }}" class="btn btn-secondary btn-lg mr-2 shadow" data-toggle="tooltip" title="Kembali ke daftar kategori">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg shadow" data-toggle="tooltip" title="Simpan kategori">
                            <i class="fas fa-save"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 