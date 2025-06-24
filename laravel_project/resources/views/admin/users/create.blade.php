@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah User Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manajemen User</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
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
                @role('admin')
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-coffee">
                                <h3 class="card-title">
                                    <i class="fas fa-user-plus mr-1"></i>
                                    Form Tambah User
                                </h3>
                            </div>
                            
                            <div class="card-body">
                                <!-- Nama -->
                                <x-input-field name="name" label="Nama Lengkap" :value="old('name')" />

                                <!-- Email -->
                                <x-input-field name="email" label="Email" type="email" :value="old('email')" />

                                <!-- Password -->
                                <x-input-field name="password" label="Password" type="password" />

                                <!-- Konfirmasi Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="Ulangi password" required>
                                </div>

                                <!-- Role -->
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" 
                                            id="role" name="role" required>
                                        <option value="" disabled selected>Pilih role</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                        <option value="barista" {{ old('role') == 'barista' ? 'selected' : '' }}>Barista</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="status_aktif" name="status" value="aktif" 
                                               class="custom-control-input" 
                                               {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} required>
                                        <label class="custom-control-label" for="status_aktif">Aktif</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="status_nonaktif" name="status" value="nonaktif" 
                                               class="custom-control-input" 
                                               {{ old('status') == 'nonaktif' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_nonaktif">Nonaktif</label>
                                    </div>
                                    @error('status')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div class="form-group">
                                    <label for="catatan">Catatan</label>
                                    <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                              id="catatan" name="catatan" rows="3" 
                                              placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan User
                                </button>
                            </div>
                        </div>
                    </form>
                @endrole
            </div>
        </div>
    </div>
</section>
@endsection 