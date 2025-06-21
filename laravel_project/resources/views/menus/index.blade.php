@extends('layouts.app')

@section('title', 'Menu Management')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
:root {
    --off-white: #faf5f0;
    --stone-gray: #a6a6a6;
    --deep-brown: #362c2a;
    --blue-glass: #7fa7b2;
    --sand: #d8c3ac;
    --primary: var(--deep-brown);
    --primary-light: var(--stone-gray);
    --primary-dark: var(--deep-brown);
    --secondary: var(--blue-glass);
    --cream: var(--off-white);
    --cream-alt: var(--off-white);
    --accent: var(--sand);
    --wood: var(--blue-glass);
    --white: #fff;
    --success: #388e3c;
    --danger: #d32f2f;
    --shadow: 0 4px 16px rgba(54, 44, 42, 0.08);
    --transition: 0.3s cubic-bezier(.4,0,.2,1);
}

body, .table, .table th, .table td {
    font-family: 'Inter', Arial, sans-serif !important;
}

body {
    background: var(--cream);
    color: var(--primary-dark);
    transition: background var(--transition), color var(--transition);
}

.dark-mode {
    background: #1E1E1E !important;
    color: #E0E0E0 !important;
}

.card {
    border-radius: 12px;
    box-shadow: var(--shadow);
    background: var(--white);
    border: none;
    margin-bottom: 24px;
    transition: background var(--transition), color var(--transition);
}

.dark-mode .card {
    background: #2D2D2D;
    color: #E0E0E0;
}

/* Tab Navigation */
.nav-tabs {
    border-bottom: 1px solid var(--wood);
    padding: 0 16px;
}

.nav-tabs .nav-link {
    color: var(--primary-light);
    font-weight: 500;
    border: none;
    padding: 12px 16px;
    position: relative;
    margin-right: 8px;
}

.nav-tabs .nav-link:hover {
    color: var(--primary);
    border-color: transparent;
}

.nav-tabs .nav-link.active {
    color: var(--primary);
    font-weight: 600;
    background: transparent;
    border: none;
}

.nav-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--primary);
}

.dark-mode .nav-tabs {
    border-bottom: 1px solid #FFD54F;
}

.dark-mode .nav-tabs .nav-link {
    color: #BDBDBD;
}

.dark-mode .nav-tabs .nav-link:hover,
.dark-mode .nav-tabs .nav-link.active {
    color: #FFD54F;
}

.dark-mode .nav-tabs .nav-link.active::after {
    background: #FFD54F;
}

/* Table Styles */
.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern th {
    background: var(--primary);
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 14px 16px;
    border-bottom: 2px solid var(--wood);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    position: sticky;
    top: 0;
    z-index: 10;
}

.table-modern td {
    padding: 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0,0,0,0.08);
    background: transparent;
    transition: background var(--transition);
    font-size: 0.95rem;
}

.table-modern tbody tr:nth-child(even) {
    background: var(--cream-alt);
}

.table-modern tbody tr:hover {
    background: rgba(255, 224, 178, 0.3) !important;
}

.table-modern .text-end {
    text-align: right !important;
}

.table-modern .text-center {
    text-align: center !important;
}

.dark-mode .table-modern th {
    background: #2D2D2D;
    color: #FFD54F;
    border-bottom: 2px solid #FFD54F;
}

.dark-mode .table-modern td {
    color: #E0E0E0;
    border-bottom: 1px solid rgba(255, 213, 79, 0.1);
}

.dark-mode .table-modern tbody tr:nth-child(even) {
    background: rgba(255, 213, 79, 0.05);
}

/* Grid View Styles */
.menu-grid {
    max-width: 1200px;
    margin: 0 auto;
}
.page-title {
    text-align: center;
    width: 100%;
}
.filter-header-card .card-body {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.filter-header-card form {
    width: 100%;
    max-width: 1100px;
}

.menu-card {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(93,64,55,0.15);
    height: 100%;
    background: var(--white);
    border: 2px solid transparent;
    transition: transform 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s, border-color 0.25s, background 0.25s;
    position: relative;
    display: flex;
    flex-direction: column;
}

.menu-card-img, .menu-card-placeholder {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    display: block;
    background: #f5f5f5;
    color: #bdbdbd;
    font-size: 2.5rem;
    text-align: center;
    line-height: 180px;
}

.menu-card-placeholder i {
    vertical-align: middle;
}

.menu-card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.menu-card-title {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 1.1rem;
    color: var(--primary-dark);
}

.menu-card-category {
    color: var(--primary-light);
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.menu-card-price {
    font-weight: 700;
    color: var(--primary-dark);
    font-size: 1.1rem;
    margin-top: auto;
    margin-bottom: 12px;
}

.menu-card:hover {
    transform: scale(1.04) translateY(-4px);
    box-shadow: 0 12px 32px rgba(93,64,55,0.22);
}

.menu-card.makanan { background: #fdf6ee; border-color: #e0c097; }
.menu-card.minuman { background: #f0f7fa; border-color: #90caf9; }
.menu-card.snack { background: #fff8e1; border-color: #ffb300; }
.menu-card.makanan:hover { border-color: #bcaaa4; }
.menu-card.minuman:hover { border-color: #42a5f5; }
.menu-card.snack:hover { border-color: #ffb300; }

.dark-mode .menu-card { background: #232323; }
.dark-mode .menu-card.makanan { background: #3e2e1e; border-color: #e0c097; }
.dark-mode .menu-card.minuman { background: #22303a; border-color: #90caf9; }
.dark-mode .menu-card.snack { background: #3a2e22; border-color: #ffb300; }

/* Common Styles */
.badge-status {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    background: rgba(56, 142, 60, 0.12);
    color: var(--success);
    border: none;
    display: inline-block;
    min-width: 90px;
    text-align: center;
}

.badge-status.tidak {
    background: rgba(211, 47, 47, 0.12);
    color: var(--danger);
}

.dark-mode .badge-status {
    background: rgba(56, 142, 60, 0.22);
    color: #A5D6A7;
}

.dark-mode .badge-status.tidak {
    background: rgba(211, 47, 47, 0.22);
    color: #FF8A80;
}

.img-thumb {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(93,64,55,0.08);
    border: 1px solid var(--wood);
    background: #fff;
    transition: transform 0.2s ease;
}

.img-thumb:hover {
    transform: scale(1.1);
}

.dark-mode .img-thumb {
    border: 1px solid #FFD54F;
    background: #232323;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(141, 110, 99, 0.12);
    color: var(--primary-light);
    margin: 0 4px;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: var(--primary-light);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(93,64,55,0.1);
}

.empty-state {
    padding: 40px 0;
    text-align: center;
    color: var(--primary-light);
}

.empty-state svg {
    width: 80px;
    height: 80px;
    margin-bottom: 16px;
    color: var(--primary-light);
}

.empty-state h5 {
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 8px;
    font-size: 1.25rem;
}

.empty-state .btn {
    background: var(--primary);
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 24px;
    font-size: 0.95rem;
    box-shadow: var(--shadow);
    transition: all 0.2s ease;
}

.empty-state .btn:hover {
    background: var(--accent);
    color: var(--primary-dark);
    transform: translateY(-2px);
}

/* Header styles */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-weight: 700;
    color: var(--primary-dark);
    margin: 0;
    font-size: 1.75rem;
}

.dark-mode .page-title {
    color: #FFD54F;
}

/* Form styles */
.filter-form {
    background: var(--white);
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
}

.dark-mode .filter-form {
    background: #2D2D2D;
}

/* Dark mode toggle */
.dark-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 100;
    transition: all 0.3s ease;
}

.dark-toggle:hover {
    transform: scale(1.1);
}

/* Responsive adjustments */
    @media (max-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
    }
    
    .table-modern th, 
    .table-modern td {
        padding: 12px;
        font-size: 0.85rem;
    }
    
    .badge-status {
        padding: 4px 8px;
        font-size: 0.8rem;
        min-width: 80px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        margin: 0 2px;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .menu-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
}

@media (max-width: 576px) {
    .menu-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .img-thumb {
        width: 40px;
        height: 40px;
    }
    
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding: 16px;
    }

    
    .nav-tabs .nav-link {
        padding: 8px 12px;
        font-size: 0.9rem;
    }
}

@media (max-width: 1200px) {
    .menu-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 900px) {
    .menu-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 600px) {
    .menu-grid { grid-template-columns: 1fr; }
}

.text-brown { color: var(--primary-dark); }
.dark-mode .text-brown { color: #FFD54F; }

/* Loading spinner */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.dark-mode .spinner-overlay {
    background: rgba(30,30,30,0.7);
}

.badge-kategori {
    position: absolute;
    top: 16px;
    left: 16px;
    background: var(--primary-light);
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 999px;
    z-index: 2;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.fav-star {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 1.3rem;
    color: #FFD54F;
    cursor: pointer;
    z-index: 2;
    transition: color 0.2s;
}

.fav-star.not-fav { color: #bdbdbd; }

.dark-mode .badge-kategori {
    background: #FFD54F;
    color: #3e2723;
}

.menu-card-action-icon {
    background: none;
    border: none;
    color: var(--primary-light);
    font-size: 1.2rem;
    margin: 0 2px;
    padding: 6px;
    border-radius: 50%;
    transition: background 0.2s, color 0.2s;
    cursor: pointer;
}
.menu-card-action-icon:hover {
    background: var(--primary-light);
    color: #fff;
}
.dark-mode .menu-card-action-icon {
    color: #FFD54F;
}
.dark-mode .menu-card-action-icon:hover {
    background: #FFD54F;
    color: #3e2723;
}

.dropdown-item i {
    font-size: 1.1rem;
    margin-right: 8px;
    color: var(--primary-light);
    vertical-align: middle;
}
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 1rem;
    padding: 8px 16px;
    transition: background 0.2s, color 0.2s;
}
.dropdown-item:hover, .dropdown-item:focus {
    background: var(--primary-light);
    color: #fff;
}
.dropdown-item.text-danger:hover, .dropdown-item.text-danger:focus {
    background: #e57373;
    color: #fff;
}
</style>

<!-- Dark mode toggle -->
<button class="dark-toggle" id="darkToggle" title="Toggle dark mode">
    <i class="bi bi-moon"></i>
</button>

<div class="container py-4">
    <!-- Loading overlay -->
    <div class="spinner-overlay" id="paginationSpinner" style="display:none;">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
    </div>

    <div class="card mb-4 filter-header-card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                <h1 class="page-title mb-0">Daftar Menu</h1>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('menus.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Menu
                    </a>
                    <button class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-gear me-2"></i>Pengaturan
                    </button>
                </div>
            </div>
            
            <!-- Filter & Search -->
            <form method="GET" class="row g-3 align-items-center mb-0" id="filterForm">
                <div class="col-md-3">
                    <label for="filterKategori" class="form-label">Kategori</label>
                    <select name="kategori" id="filterKategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="Makanan" {{ request('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ request('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Dessert" {{ request('kategori') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterStatus" class="form-label">Status</label>
                    <select name="status" id="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Tidak tersedia" {{ request('status') == 'Tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Urutkan</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="">Default</option>
                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="kategori_asc" {{ request('sort') == 'kategori_asc' ? 'selected' : '' }}>Kategori A-Z</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga (Rp)</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="harga_min" class="form-control" placeholder="Min" value="{{ request('harga_min') }}">
                        <input type="number" name="harga_max" class="form-control" placeholder="Max" value="{{ request('harga_max') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="searchNama" class="form-label">Cari Menu</label>
                    <input type="text" name="search" id="searchNama" class="form-control" placeholder="Cari berdasarkan nama menu..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 position-relative d-flex align-items-center justify-content-center">
                        <span id="filterSpinner" class="spinner-border spinner-border-sm me-2" style="display:none;"></span>
                        <span>Terapkan</span>
                    </button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs" id="viewTabs" role="tablist">
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content" id="viewTabsContent">
                <!-- Table View -->
                <div class="tab-pane fade show active" id="table-view" role="tabpanel" aria-labelledby="table-tab">
                    <!-- Table View content will be removed -->
                </div>
                
                <!-- Grid View -->
                <div class="tab-pane fade" id="grid-view" role="tabpanel" aria-labelledby="grid-tab">
                    @if($menus->count())
                    <div class="menu-grid-wrapper">
                        <div class="menu-grid">
            @foreach($menus as $menu)
                            <div class="menu-card {{ strtolower($menu->kategori) }}">
                                <span class="badge-kategori">{{ $menu->kategori }}</span>
                                <span class="fav-star not-fav" onclick="toggleFav(this)" title="Favorit"><i class="bi bi-star-fill"></i></span>
                    @if($menu->gambar)
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" class="menu-card-img" alt="{{ $menu->nama }}">
                                @else
                                    <div class="menu-card-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                <div class="menu-card-body">
                                    <h5 class="menu-card-title">{{ $menu->nama }}</h5>
                                    <div class="menu-card-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge-status{{ $menu->status == 'Tersedia' ? '' : ' tidak' }}">{{ $menu->status }}</span>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0" type="button" id="dropdownMenu{{ $menu->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu{{ $menu->id }}">
                                                <li><a class="dropdown-item" href="{{ route('menus.edit', $menu->id) }}"><i class="bi bi-pencil-square"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bi bi-files"></i>Duplikat</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash"></i>Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('menus.show', $menu->id) }}" class="btn btn-outline-primary w-100 mt-2">
                                        <i class="bi bi-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="empty-state py-5">
                        <svg viewBox="0 0 24 24" width="80" height="80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h5 class="mt-3 mb-2">Belum ada menu tersedia</h5>
                        <p class="text-muted mb-4">Mulai dengan menambahkan menu baru</p>
                        <a href="{{ route('menus.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i>Tambah Menu
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Pagination -->
            @if($menus->hasPages())
            <div class="d-flex justify-content-center py-3">
                {{ $menus->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Dark mode toggle
const darkToggle = document.getElementById('darkToggle');
const html = document.documentElement;

if(localStorage.getItem('dark-mode') === 'true') {
    html.classList.add('dark-mode');
    darkToggle.innerHTML = '<i class="bi bi-sun"></i>';
}

darkToggle.onclick = function() {
    html.classList.toggle('dark-mode');
    if(html.classList.contains('dark-mode')) {
        darkToggle.innerHTML = '<i class="bi bi-sun"></i>';
        localStorage.setItem('dark-mode', 'true');
    } else {
        darkToggle.innerHTML = '<i class="bi bi-moon"></i>';
        localStorage.setItem('dark-mode', 'false');
    }
}

// Form submission spinner
document.getElementById('filterForm').onsubmit = function() {
    document.getElementById('filterSpinner').style.display = 'inline-block';
};

// Reset filter
function resetFilter() {
    document.getElementById('filterKategori').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('sort').value = '';
    document.getElementById('harga_min').value = '';
    document.getElementById('harga_max').value = '';
    document.getElementById('searchNama').value = '';
    document.getElementById('filterForm').submit();
}

// Pagination spinner
document.querySelectorAll('.pagination a').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('paginationSpinner').style.display = 'flex';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Simulate loading delay
        setTimeout(() => {
            window.location.href = this.href;
        }, 500);
    });
});

// Remember tab selection
document.addEventListener('DOMContentLoaded', function() {
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        const tab = new bootstrap.Tab(document.querySelector(activeTab));
        tab.show();
    }
    
    document.querySelectorAll('#viewTabs button').forEach(tab => {
        tab.addEventListener('click', function() {
            localStorage.setItem('activeTab', this.getAttribute('data-bs-target'));
        });
    });
});

// Reset spinner when page is shown
window.addEventListener('pageshow', function() {
    document.getElementById('paginationSpinner').style.display = 'none';
    document.getElementById('filterSpinner').style.display = 'none';
});

function toggleFav(el) {
    el.classList.toggle('not-fav');
}
</script>
@endsection