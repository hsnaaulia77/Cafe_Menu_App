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
        
        @php
            $role = auth()->user()->role ?? null;
        @endphp

        <style>
            :root {
                --off-white: #faf5f0;
                --stone-gray: #a6a6a6;
                --deep-brown: #362c2a;
                --blue-glass: #7fa7b2;
                --sand: #d8c3ac;
            }

            /* Override AdminLTE Primary Color */
            .btn-primary, .btn-primary:hover {
                background-color: var(--deep-brown) !important;
                border-color: var(--stone-gray) !important;
            }
            .card-primary.card-outline {
                background-color: #fff !important;
                border-color: var(--stone-gray) !important;
            }
            .btn-primary:focus, .btn-primary.focus {
                 box-shadow: 0 0 0 0.2rem rgba(54, 44, 42, 0.5) !important;
            }

            /* Sidebar Color Scheme */
            @if($role === 'admin')
                [class*=sidebar-dark-] { background-color: var(--deep-brown) !important; }
            @elseif($role === 'customer')
                [class*=sidebar-dark-] { background-color: #2a3f54 !important; }
            @elseif($role === 'cashier')
                [class*=sidebar-dark-] { background-color: #1b5e20 !important; }
            @endif
            .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
                background-color: var(--stone-gray);
            }
            
            /* Navbar Color */
            .main-header.navbar {
                background-color: #fff;
                border-bottom: 1px solid #dee2e6;
            }

            /* Custom Card Header */
            .card-header.card-header-coffee {
                background-color: var(--deep-brown);
                color: white;
            }

            /* Custom Small Box Colors */
            .bg-coffee-1 { background-color: var(--sand) !important; color: var(--deep-brown) !important; }
            .bg-coffee-2 { background-color: var(--blue-glass) !important; color: white !important; }
            .bg-coffee-3 { background-color: var(--stone-gray) !important; color: var(--deep-brown) !important; }
            .bg-coffee-4 { background-color: var(--deep-brown) !important; color: white !important; }
            .bg-coffee-1 .small-box-footer, .bg-coffee-3 .small-box-footer { color: var(--deep-brown) !important; }
            .bg-coffee-2 .small-box-footer, .bg-coffee-4 .small-box-footer { color: white !important; }
        </style>
        @stack('styles')
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

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
                    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ optional(Auth::user())->name ?? 'Admin' }}</a>
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
                                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chair"></i>
                                    <p>Meja</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('menu_items.index') }}" class="nav-link {{ request()->routeIs('menu_items.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-hamburger"></i>
                                    <p>Menu Item</p>
                                </a>
                            </li>
                            @if($role === 'admin')
                                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                                <li class="nav-item"><a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}"><i class="nav-icon fas fa-utensils"></i><p>Menu Management</p></a></li>
                                <li class="nav-item"><a href="{{ route('admin.kategori_menu.index') }}" class="nav-link {{ request()->routeIs('admin.kategori_menu.*') ? 'active' : '' }}"><i class="nav-icon fas fa-list"></i><p>Kategori Menu</p></a></li>
                                <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="nav-icon fas fa-users"></i><p>Manajemen User</p></a></li>
                                <li class="nav-item"><a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="nav-icon fas fa-shopping-cart"></i><p>Manajemen Order</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-chart-bar"></i><p>Laporan Transaksi</p></a></li>
                            @elseif($role === 'customer')
                                <li class="nav-item"><a href="{{ route('menu.browse') }}" class="nav-link"><i class="nav-icon fas fa-coffee"></i><p>Daftar Menu</p></a></li>
                                <li class="nav-item"><a href="{{ route('cart.index') }}" class="nav-link"><i class="nav-icon fas fa-shopping-cart"></i><p>Keranjang</p></a></li>
                                <li class="nav-item"><a href="{{ route('orders.index') }}" class="nav-link"><i class="nav-icon fas fa-history"></i><p>Riwayat Pemesanan</p></a></li>
                                <li class="nav-item"><a href="{{ route('profile.edit') }}" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Profil</p></a></li>
                            @elseif($role === 'cashier')
                                <li class="nav-item"><a href="{{ route('cashier.orders.index') }}" class="nav-link"><i class="nav-icon fas fa-inbox"></i><p>Pesanan Masuk</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-cash-register"></i><p>Pembayaran</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-history"></i><p>Riwayat Transaksi</p></a></li>
                            @endif
                            <li class="nav-header">SETTINGS</li>
                            <li class="nav-item"><a href="{{ route('profile.edit') }}" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Profile</p></a></li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="nav-icon fas fa-sign-out-alt"></i>
                                        <p>Logout</p>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <main>
                @yield('content')
                </main>
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="float-right d-none d-sm-inline">
                    Version 1.0.0
                </div>
                <strong>Copyright &copy; 2024 <a href="#">{{ config('app.name', 'Laravel') }}</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
        <!-- ChartJS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @stack('scripts')
    </body>
</html>
