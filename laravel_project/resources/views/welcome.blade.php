@extends('layouts.app')

@section('title', 'Selamat Datang - Coffee Menu App')

@section('content')
<!-- Hero Section -->
<div class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 font-weight-bold mb-4">Selamat Datang di Coffee Menu App</h1>
                <p class="lead mb-4">Kelola menu kafe Anda dengan mudah dan efisien. Sistem manajemen menu yang modern dan user-friendly.</p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/coffee-login.jpg') }}" alt="Coffee" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="content py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="h1 mb-3">Fitur Unggulan</h2>
                <p class="lead text-muted">Nikmati kemudahan mengelola menu kafe Anda</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-utensils fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Manajemen Menu</h4>
                        <p class="card-text">Kelola menu dengan mudah. Tambah, edit, dan hapus menu dengan interface yang intuitif.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shopping-cart fa-3x text-success"></i>
                        </div>
                        <h4 class="card-title">Sistem Pesanan</h4>
                        <p class="card-text">Proses pesanan pelanggan dengan cepat dan efisien. Lacak status pesanan real-time.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-chart-bar fa-3x text-info"></i>
                        </div>
                        <h4 class="card-title">Analytics & Laporan</h4>
                        <p class="card-text">Lihat statistik penjualan dan laporan detail untuk pengambilan keputusan yang lebih baik.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-mobile-alt fa-3x text-warning"></i>
                        </div>
                        <h4 class="card-title">Responsive Design</h4>
                        <p class="card-text">Akses dari mana saja. Interface yang responsif untuk desktop, tablet, dan mobile.</p>
                    </div>
                </div>
        </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt fa-3x text-danger"></i>
                        </div>
                        <h4 class="card-title">Keamanan Tinggi</h4>
                        <p class="card-text">Sistem keamanan yang kuat dengan autentikasi dan otorisasi yang terjamin.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-clock fa-3x text-secondary"></i>
                        </div>
                        <h4 class="card-title">24/7 Tersedia</h4>
                        <p class="card-text">Sistem yang selalu siap melayani. Akses menu dan pesanan kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <i class="fas fa-utensils fa-2x text-primary mb-3"></i>
                    <h3 class="h2 font-weight-bold text-primary">{{ $totalMenus ?? 0 }}</h3>
                    <p class="text-muted">Total Menu</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <i class="fas fa-shopping-cart fa-2x text-success mb-3"></i>
                    <h3 class="h2 font-weight-bold text-success">{{ $totalOrders ?? 0 }}</h3>
                    <p class="text-muted">Total Pesanan</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <i class="fas fa-users fa-2x text-info mb-3"></i>
                    <h3 class="h2 font-weight-bold text-info">{{ $totalUsers ?? 0 }}</h3>
                    <p class="text-muted">Pengguna Aktif</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <i class="fas fa-star fa-2x text-warning mb-3"></i>
                    <h3 class="h2 font-weight-bold text-warning">4.8</h3>
                    <p class="text-muted">Rating Sistem</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2 class="h1 mb-4">Siap Memulai?</h2>
        <p class="lead mb-4">Bergabunglah dengan ribuan kafe yang telah menggunakan sistem kami</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                <i class="fas fa-rocket"></i> Mulai Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn-light btn-lg mr-3">
                <i class="fas fa-user-plus"></i> Daftar Gratis
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        @endauth
    </div>
</section>

<style>
.hero-section {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.feature-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-item {
    padding: 2rem 1rem;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.hero-buttons .btn {
    transition: all 0.3s ease;
}

.hero-buttons .btn:hover {
    transform: translateY(-2px);
}
</style>
@endsection
