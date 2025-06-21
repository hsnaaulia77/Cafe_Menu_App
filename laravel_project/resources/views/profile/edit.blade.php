@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
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
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="https://via.placeholder.com/128x128?text=User" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                        <p class="text-muted text-center">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Profile</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Update Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="current_password">Password Saat Ini</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" autocomplete="current-password">
                                @error('current_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Hapus Akun</h3>
                    </div>
                    <div class="card-body">
                        <div class="max-w-xl text-sm text-gray-600">
                            <p>Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi yang ingin Anda simpan.</p>
            </div>

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-user-deletion">
                            <i class="fas fa-trash"></i> Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi Hapus Akun -->
<div class="modal fade" id="confirm-user-deletion" tabindex="-1" role="dialog" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h5 class="modal-title" id="confirm-user-deletion-label">Apakah Anda yakin ingin menghapus akun Anda?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan password Anda untuk mengkonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.</p>

                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
