@extends('layouts.admin')

@section('title', 'Analitik Menu')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Analitik Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.menus.index') }}">Menu</a></li>
                        <li class="breadcrumb-item active">Analitik</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info Boxes -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Menu Aktif</span>
                            <span class="info-box-number">{{ $menuStatus['active'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-times-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Menu Tidak Aktif</span>
                            <span class="info-box-number">{{ $menuStatus['inactive'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Chart: Revenue by Category -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pendapatan per Kategori</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueByCategoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Table: Top Selling Items -->
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Top 5 Menu Terlaris</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-right">Total Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topSellingItems as $item)
                                        <tr>
                                            <td>{{ $item->menu->nama ?? 'Menu Dihapus' }}</td>
                                            <td class="text-right">{{ $item->total_sold }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Belum ada data penjualan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart: Sales Trend -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Tren Penjualan (30 Hari Terakhir)</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
    $(function () {
        // --- Revenue by Category Chart (Doughnut) ---
        var revenueByCategoryCtx = document.getElementById('revenueByCategoryChart').getContext('2d');
        new Chart(revenueByCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($categoryData),
                    backgroundColor: [
                        '#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d',
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // --- Sales Trend Chart (Line) ---
        var salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: @json($salesTrendLabels),
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: @json($salesTrendData),
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                            return label;
                        }
                    }
                }
            }
        });
    });
</script>
@endpush 