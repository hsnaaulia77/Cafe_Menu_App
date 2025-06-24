@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="badge badge-info">Anda</span>
                            @endif
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Nama:</strong></td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Role:</strong></td>
                                        <td>
                                            @switch($user->role)
                                                @case('admin')
                                                    <span class="badge badge-danger">Admin</span>
                                                    @break
                                                @case('kasir')
                                                    <span class="badge badge-warning">Kasir</span>
                                                    @break
                                                @case('barista')
                                                    <span class="badge badge-info">Barista</span>
                                                    @break
                                                @case('customer')
                                                    <span class="badge badge-success">Customer</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($user->status === 'aktif')
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Terdaftar:</strong></td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Terakhir Update:</strong></td>
                                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Verified:</strong></td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge badge-success">Terverifikasi</span>
                                                <br><small class="text-muted">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge badge-warning">Belum Verifikasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($user->catatan)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Catatan:</h5>
                                <div class="alert alert-info">
                                    {{ $user->catatan }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- User Statistics (if needed) -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Statistik User:</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Orders</span>
                                                <span class="info-box-number">0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Spending</span>
                                                <span class="info-box-number">Rp 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Last Login</span>
                                                <span class="info-box-number">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-danger"><i class="fas fa-calendar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Member Since</span>
                                                <span class="info-box-number">{{ $user->created_at->format('M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn {{ $user->status === 'aktif' ? 'btn-danger' : 'btn-success' }}" 
                                            onclick="return confirm('Yakin ingin {{ $user->status === 'aktif' ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
                                        <i class="fas {{ $user->status === 'aktif' ? 'fa-ban' : 'fa-check' }}"></i> 
                                        {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            @else
                                <div></div>
                            @endif
                            <div>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 