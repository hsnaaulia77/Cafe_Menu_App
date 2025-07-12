<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Coffee Menu App')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- AdminLTE style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">
        
        @php
            $role = auth()->user()->role ?? null;
        @endphp

        <!-- Dark Mode Elegant Global -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
        <style>
            body, html {
                background: linear-gradient(135deg, #18181c 0%, #232526 100%) !important;
                color: #fff !important;
                font-family: 'Montserrat', 'Lato', sans-serif !important;
            }
            .main-header.navbar, .main-footer, .content-wrapper, .sidebar, .main-sidebar, .brand-link {
                background: rgba(30,30,35,0.95) !important;
                color: #fff !important;
                border: none !important;
            }
            .sidebar-dark-primary, .main-sidebar, .sidebar {
                background: #18181c !important;
                color: #ffd700 !important;
            }
            .sidebar .nav-link, .sidebar .nav-header, .sidebar .brand-link {
                color: #ffd700 !important;
            }
            .sidebar .nav-link.active, .sidebar .nav-link:hover {
                background: linear-gradient(90deg, #232526 0%, #18181c 100%) !important;
                color: #ffd700 !important;
                border-radius: 1.2rem !important;
            }
            .sidebar .nav-icon, .sidebar .brand-link .brand-image {
                color: #ffd700 !important;
            }
            .main-header.navbar, .main-footer {
                background: rgba(30,30,35,0.95) !important;
                color: #ffd700 !important;
                border: none !important;
            }
            .content-wrapper {
                background: transparent !important;
            }
            .card, .form-control, .list-group-item {
                background: rgba(30,30,35,0.92) !important;
                color: #fff !important;
                border: none !important;
                border-radius: 1.2rem !important;
                box-shadow: 0 4px 24px #0008 !important;
                font-family: 'Lato', 'Montserrat', sans-serif !important;
            }
            .form-control {
                background: rgba(40,40,45,0.5) !important;
                border: 1.5px solid #ffd70033 !important;
                color: #fff !important;
                border-radius: 0.8rem !important;
                padding: 0.8rem 1rem !important;
                margin-bottom: 1.1rem !important;
                font-size: 1rem !important;
                transition: border 0.2s !important;
                backdrop-filter: blur(4px) !important;
            }
            .form-control:focus {
                border: 1.5px solid #ffd700 !important;
                background: rgba(40,40,45,0.9) !important;
                color: #fff !important;
            }
            .card-header {
                background: transparent !important;
                color: #ffd700 !important;
                font-weight: 700 !important;
                border-bottom: 1px solid #ffd70033 !important;
                font-family: 'Montserrat', sans-serif !important;
            }
            .btn-cafe, .btn-primary, .btn-success, .btn-warning, .btn-info, .btn-outline-primary, .btn-outline-secondary {
                background: linear-gradient(90deg, #ffd700 0%, #b87333 100%) !important;
                color: #18181c !important;
                font-weight: 700 !important;
                border-radius: 0.8rem !important;
                border: none !important;
                font-size: 1.1rem !important;
                box-shadow: 0 2px 12px #b8733340 !important;
                transition: box-shadow 0.2s, transform 0.2s !important;
                margin-right: 0.5rem !important;
                margin-bottom: 0.5rem !important;
            }
            .btn-cafe:hover, .btn-primary:hover, .btn-success:hover, .btn-warning:hover, .btn-info:hover, .btn-outline-primary:hover, .btn-outline-secondary:hover {
                box-shadow: 0 4px 24px #ffd70080 !important;
                transform: translateY(-2px) scale(1.03) !important;
            }
            .badge-cafe, .badge, .badge-pill {
                background: linear-gradient(90deg, #ffd700 0%, #b87333 100%) !important;
                color: #18181c !important;
                border-radius: 1rem !important;
                font-size: 0.9rem !important;
                padding: 0.2rem 0.7rem !important;
                font-weight: 700 !important;
            }
            .list-group-item {
                background: rgba(30,30,35,0.92) !important;
                color: #fff !important;
                border: none !important;
            }
            .text-gold { color: #ffd700 !important; }
            .text-coffee { color: #b87333 !important; }
            .bg-coffee { background: #b87333 !important; color: #fff !important; }
            .bg-gold { background: #ffd700 !important; color: #18181c !important; }
            .brand-title, .dashboard-logo .brand {
                color: #ffd700 !important;
                font-family: 'Montserrat', sans-serif !important;
                text-shadow: 0 2px 12px #b8733340 !important;
            }
            .brand-subtitle {
                color: #e0b873 !important;
                font-family: 'Lato', sans-serif !important;
            }
        </style>
        @stack('styles')
    </head>
    <body class="hold-transition sidebar-mini">
        <div id="particle-bg"></div>
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark bg-dark px-3">
                <button class="btn btn-cafe d-lg-none me-2" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand">Noir Cafe</span>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <span class="float-right text-muted text-sm">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                                <span class="float-right text-muted text-sm">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="brand-link">
                    <i class="fas fa-coffee brand-image img-circle elevation-3" style="opacity: .8"></i>
                    <span class="brand-text font-weight-light">Noir Cafe</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ Auth::user()->name ?? 'Admin' }}</a>
                        </div>
                    </div>
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('menu_items.index') }}" class="nav-link {{ request()->routeIs('menu_items.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-utensils"></i>
                                    <p>Menu Items</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chair"></i>
                                    <p>Tables</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('promotions.index') }}" class="nav-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-gift"></i>
                                    <p>Promotions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reviews.index') }}" class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-star"></i>
                                    <p>Reviews</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link" style="background:none;border:none;padding:0;margin:0;cursor:pointer;display:flex;align-items:center;width:100%;">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                        <p style="margin-bottom:0;margin-left:8px;">Logout</p>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper p-4">
                @yield('content')
            </div>

            <footer class="main-footer">
                <div class="float-right d-none d-sm-inline">
                    Version 1.0.0
                </div>
                <strong>Copyright &copy; 2024 <a href="#">{{ config('app.name', 'Laravel') }}</a>.</strong> All rights reserved.
            </footer>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
        <!-- ChartJS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @stack('scripts')
        <script>
        // Simple Particle Effect
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.createElement('canvas');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            canvas.style.width = '100vw';
            canvas.style.height = '100vh';
            canvas.style.position = 'absolute';
            canvas.style.top = 0;
            canvas.style.left = 0;
            canvas.style.pointerEvents = 'none';
            const ctx = canvas.getContext('2d');
            document.getElementById('particle-bg').appendChild(canvas);
            let particles = [];
            for(let i=0;i<40;i++){
                particles.push({
                    x: Math.random()*canvas.width,
                    y: Math.random()*canvas.height,
                    r: Math.random()*2+1,
                    dx: (Math.random()-0.5)*0.5,
                    dy: (Math.random()-0.5)*0.5,
                    o: Math.random()*0.5+0.2
                });
            }
            function drawParticles(){
                ctx.clearRect(0,0,canvas.width,canvas.height);
                for(let p of particles){
                    ctx.beginPath();
                    ctx.arc(p.x,p.y,p.r,0,2*Math.PI);
                    ctx.fillStyle = `rgba(255,215,0,${p.o})`;
                    ctx.shadowColor = '#FFD700';
                    ctx.shadowBlur = 8;
                    ctx.fill();
                    p.x += p.dx;
                    p.y += p.dy;
                    if(p.x<0||p.x>canvas.width) p.dx*=-1;
                    if(p.y<0||p.y>canvas.height) p.dy*=-1;
                }
                requestAnimationFrame(drawParticles);
            }
            drawParticles();
            window.addEventListener('resize',()=>{
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.main-sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            if(sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.onclick = function() {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                };
                sidebarOverlay.onclick = function() {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                };
            }
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html>
