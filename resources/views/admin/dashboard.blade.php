@extends('admin.layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-heading">
        <h3>Dashboard Admin</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <!-- Total Meja -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Total Meja</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalMeja }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Total Menu -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Total Menu</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalMenu }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Total Order -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Total Order</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalOrder }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Total Review -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Total Review</h6>
                               <h6 class="font-extrabold mb-0">{{ $totalReview }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
