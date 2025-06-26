@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <!-- Statistik Kecil -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>112</h3>
                    <p>Order Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>183</h3>
                    <p>Menu Terjual</p>
                </div>
                <div class="icon">
                    <i class="fas fa-utensils"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>89</h3>
                    <p>Pelanggan Baru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>112</h3>
                    <p>Meja Terpakai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chair"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Info -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header card-header-coffee">
                    <h3 class="card-title">Profile Visit</h3>
                </div>
                <div class="card-body">
                    <canvas id="barChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- User Profile & Menu Populer -->
            <div class="card">
                <div class="card-header card-header-coffee">
                    <h3 class="card-title">User Profile</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2 mr-2" width="40" alt="User">
                        <span>Admin Tamu</span>
                    </div>
                    <h6>Menu Populer</h6>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Menu 1 <span class="badge badge-primary badge-pill">12</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Menu 2 <span class="badge badge-primary badge-pill">9</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Menu 3 <span class="badge badge-primary badge-pill">7</span>
                        </li>
                    </ul>
                    <canvas id="pieChart" style="height:180px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Traffic & Review -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header card-header-coffee">
                    <h3 class="card-title">Traffic Pemesanan</h3>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" style="height:180px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header card-header-coffee">
                    <h3 class="card-title">Latest Review</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg" width="30" class="img-circle mr-2"> Si Cantik</td>
                                <td>Congratulations on your application.</td>
                            </tr>
                            <tr>
                                <td><img src="https://adminlte.io/themes/v3/dist/img/user8-128x128.jpg" width="30" class="img-circle mr-2"> Si Ganteng</td>
                                <td>Aku sangat menyukai cafe, suasananya nyaman dan kopinya enak.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart
    var ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Profile Visit',
                data: [2, 4, 6, 8, 5, 7, 6, 8, 7, 9, 6, 5],
                backgroundColor: '#3498db'
            }]
        }
    });

    // Pie Chart
    var ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Menu 1', 'Menu 2', 'Menu 3'],
            datasets: [{
                data: [12, 9, 7],
                backgroundColor: ['#3498db', '#2ecc71', '#e74c3c']
            }]
        }
    });

    // Line Chart
    var ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Makanan', 'Minuman', 'Cemilan'],
            datasets: [{
                label: 'Traffic',
                data: [862, 375, 1025],
                borderColor: '#e67e22',
                backgroundColor: 'rgba(230, 126, 34, 0.2)',
                fill: true
            }]
        }
    });
</script>
@endpush
