@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- Total Meja -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>112</h3>
                        <p>Total Meja</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Total Menu -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>183</h3>
                        <p>Total Menu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Total Order -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>80</h3>
                        <p>Total Order</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Total Review -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>112</h3>
                        <p>Total Review</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comment"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Profile Visit
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="chart-profile-visit" style="position: relative; height: 300px;">
                                <canvas id="profileVisitChartCanvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- Traffic Pemesanan Chart -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Traffic Pemesanan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Jumlah Pemesanan</strong>
                                </p>

                                <div class="progress-group">
                                    Makanan
                                    <span class="float-right"><b>862</b>/2000</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 43.1%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                    Minuman
                                    <span class="float-right"><b>375</b>/2000</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 18.75%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                    Cemilan
                                    <span class="float-right"><b>1025</b>/2000</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 51.25%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            </div>
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="trafficPemesananChartCanvas" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

            </section>
            <!-- /.Left col -->

            <section class="col-lg-5 connectedSortable">
                <!-- Latest Review -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comments mr-1"></i>
                            Latest Review
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Comment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('admin-assets/img/user5-128x128.jpg') }}" alt="User Image">
                                            <span class="username">
                                                <a href="#">Si Cantik</a>
                                            </span>
                                            <span class="description"></span>
                                        </div>
                                    </td>
                                    <td>Congratulations on your graduation!</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('admin-assets/img/user2-160x160.jpg') }}" alt="User Image">
                                            <span class="username">
                                                <a href="#">Si Ganteng</a>
                                            </span>
                                            <span class="description"></span>
                                        </div>
                                    </td>
                                    <td>
                                        Wow amazing design! Can you make another tutorial for this design?
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- Profile Widget -->
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-warning">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="{{ asset('admin-assets/img/user1-128x128.jpg') }}" alt="User Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username">Admin Sans</h3>
                        <h5 class="widget-user-desc">@johnducky</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Pemesanan Terbaru <span class="float-right badge bg-primary">3</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Meja 1 <span class="float-right badge bg-info">New</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Meja 2 <span class="float-right badge bg-info">New</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Meja 3 <span class="float-right badge bg-info">New</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Selengkapnya <span class="float-right badge bg-secondary">More</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.widget-user-2 -->

                <!-- Visitors Profile Chart -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Visitors Profile
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="chart-visitors-profile" style="position: relative; height: 300px;">
                                <canvas id="visitorsProfileChartCanvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
<script>
    $(function () {
        'use strict'

        // Profile Visit Chart
        var profileVisitChartCanvas = $('#profileVisitChartCanvas').get(0).getContext('2d')
        var profileVisitChartData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Visits',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90, 70, 80, 90, 70, 80] // Dummy data
                }
            ]
        }
        var profileVisitChartOptions = { // Define options for profile visit chart
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines : {
                        display : false,
                    }
                }],
                yAxes: [{
                    gridLines : {
                        display : false,
                    }
                }]
            }
        }
        new Chart(profileVisitChartCanvas, {
            type: 'bar',
            data: profileVisitChartData,
            options: profileVisitChartOptions
        })

        // Traffic Pemesanan Chart (Bar Chart)
        var trafficPemesananChartCanvas = $('#trafficPemesananChartCanvas').get(0).getContext('2d')
        var trafficPemesananChartData = {
            labels: ['Makanan', 'Minuman', 'Cemilan'],
            datasets: [
                {
                    label: 'Jumlah',
                    backgroundColor: ['#007bff', '#dc3545', '#28a745'], // Blue, Red, Green for categories
                    borderColor: ['#007bff', '#dc3545', '#28a745'],
                    borderWidth: 1,
                    data: [862, 375, 1025] // Dummy data from your original layout
                }
            ]
        }
        var trafficPemesananChartOptions = { // Define options for traffic pemesanan chart
            responsive              : true,
            maintainAspectRatio     : false,
            scales: {
                xAxes: [{
                    gridLines : {
                        display : false,
                    }
                }],
                yAxes: [{
                    gridLines : {
                        display : false,
                    }
                }]
            }
        }
        new Chart(trafficPemesananChartCanvas, {
            type: 'bar',
            data: trafficPemesananChartData,
            options: trafficPemesananChartOptions
        })


        // Visitors Profile Chart (Donut Chart)
        var visitorsProfileChartCanvas = $('#visitorsProfileChartCanvas').get(0).getContext('2d')
        var visitorsProfileChartData = {
            labels: [
                'Direct',
                'Referral',
                'Social'
            ],
            datasets: [
                {
                    data: [700, 500, 400], // Dummy data
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12'] // Red, Green, Yellow
                }
            ]
        }
        var visitorsProfileChartOptions = { // Define options for visitors profile chart
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: false
            }
        }
        new Chart(visitorsProfileChartCanvas, {
            type: 'doughnut',
            data: visitorsProfileChartData,
            options: visitorsProfileChartOptions
        })
    })
</script>
@endpush 