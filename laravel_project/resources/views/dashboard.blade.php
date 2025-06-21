@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-utensils"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Menu</span>
                        <span class="info-box-number">{{ $totalMenus ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Menu Tersedia</span>
                        <span class="info-box-number">{{ $availableMenus ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Menu Tidak Tersedia</span>
                        <span class="info-box-number">{{ $unavailableMenus ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pesanan</span>
                        <span class="info-box-number">{{ $totalOrders ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Pesanan Terbaru</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders ?? [] as $order)
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">#{{ $order->id }}</a></td>
                                        <td>{{ $order->customer_name ?? 'Guest' }}</td>
                                        <td>
                                            @if($order->status == 'completed')
                                                <span class="badge badge-success">Selesai</span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @else
                                                <span class="badge badge-info">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pesanan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-info float-left">Lihat Semua Pesanan</a>
                        <a href="{{ route('orders.create') }}" class="btn btn-sm btn-secondary float-right">Buat Pesanan Baru</a>
                    </div>
                </div>

                <!-- PRODUCT LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menu Terbaru</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @forelse($recentMenus ?? [] as $menu)
                            <li class="item">
                                <div class="product-img">
                                    @if($menu->gambar)
                                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="img-size-50">
                                    @else
                                        <img src="https://via.placeholder.com/50x50?text=Menu" alt="Placeholder" class="img-size-50">
                                    @endif
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{ $menu->nama }}
                                        @if($menu->status == 'Tersedia')
                                            <span class="badge badge-success float-right">Tersedia</span>
                                        @else
                                            <span class="badge badge-warning float-right">Tidak Tersedia</span>
                                        @endif
                                    </a>
                                    <span class="product-description">
                                        {{ Str::limit($menu->deskripsi, 50) }}
                                    </span>
                                </div>
                            </li>
                            @empty
                            <li class="item">
                                <div class="product-info">
                                    <span class="product-description">Belum ada menu</span>
                                </div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('menus.index') }}" class="uppercase">Lihat Semua Menu</a>
                    </div>
                </div>
            </div>

            <!-- Right col -->
            <div class="col-md-4">
                <!-- PRODUCT LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menu Berdasarkan Kategori</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($menuCategories ?? [] as $category => $count)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{ $category }}
                                        <span class="badge badge-info float-right">{{ $count }}</span>
                                    </a>
                                    <span class="product-description">
                                        Menu dalam kategori ini
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="card bg-gradient-success">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="far fa-calendar-alt"></i>
                            Calendar
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="calendar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(function () {
    // Calendar
    $('#calendar').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
});
</script>
@endpush
