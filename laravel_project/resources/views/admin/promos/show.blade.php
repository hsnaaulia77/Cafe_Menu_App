@extends('layouts.app')

@section('title', 'Detail Promo')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Promo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.promos.index') }}">Promo & Kupon</a></li>
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
                            <i class="fas fa-tags"></i> {{ $promo->nama }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Nama Promo:</strong></td>
                                        <td>{{ $promo->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis:</strong></td>
                                        <td>
                                            @switch($promo->jenis)
                                                @case('diskon_persen')
                                                    <span class="badge badge-info">Diskon {{ $promo->nilai }}%</span>
                                                    @break
                                                @case('diskon_nominal')
                                                    <span class="badge badge-success">Diskon Rp {{ number_format($promo->nilai, 0, ',', '.') }}</span>
                                                    @break
                                                @case('voucher')
                                                    <span class="badge badge-warning">Voucher</span>
                                                    @break
                                                @case('bundle')
                                                    <span class="badge badge-primary">Bundle</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nilai:</strong></td>
                                        <td>
                                            @if($promo->jenis === 'diskon_persen')
                                                {{ $promo->nilai }}%
                                            @else
                                                Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                    @if($promo->kode_kupon)
                                    <tr>
                                        <td><strong>Kode Kupon:</strong></td>
                                        <td><code>{{ $promo->kode_kupon }}</code></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><strong>Minimum Pembelian:</strong></td>
                                        <td>
                                            @if($promo->minimum_pembelian > 0)
                                                Rp {{ number_format($promo->minimum_pembelian, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">Tidak ada minimum</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Status:</strong></td>
                                        <td>
                                            @if($promo->isActive())
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Periode:</strong></td>
                                        <td>
                                            {{ $promo->tanggal_mulai->format('d/m/Y') }} - {{ $promo->tanggal_berakhir->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Penggunaan:</strong></td>
                                        <td>
                                            @if($promo->maksimal_penggunaan)
                                                {{ $promo->sudah_digunakan }}/{{ $promo->maksimal_penggunaan }}
                                            @else
                                                {{ $promo->sudah_digunakan }}/∞
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $promo->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diupdate:</strong></td>
                                        <td>{{ $promo->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($promo->deskripsi)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Deskripsi:</h5>
                                <p>{{ $promo->deskripsi }}</p>
                            </div>
                        </div>
                        @endif

                        @if($promo->jenis === 'bundle' && $promo->menu_bundle)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Menu Bundle:</h5>
                                <div class="row">
                                    @foreach($promo->menu_bundle as $menuId)
                                        @php
                                            $menu = \App\Models\Menu::find($menuId);
                                        @endphp
                                        @if($menu)
                                        <div class="col-md-6 mb-2">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center">
                                                        @if($menu->gambar)
                                                            <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                                                 alt="{{ $menu->nama }}" 
                                                                 class="img-fluid rounded" 
                                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-utensils text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div class="ml-3">
                                                            <h6 class="mb-0">{{ $menu->nama }}</h6>
                                                            <small class="text-muted">Rp {{ number_format($menu->harga, 0, ',', '.') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus promo ini?')">
                                    <i class="fas fa-trash"></i> Hapus Promo
                                </button>
                            </form>
                            <div>
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
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