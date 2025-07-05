@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- DARK/LIGHT TOGGLE --}}
    <div class="form-check form-switch ms-auto mb-3" style="max-width: 180px;">
        <input class="form-check-input" type="checkbox" id="themeSwitch">
        <label class="form-check-label" for="themeSwitch">🌙 / ☀️</label>
    </div>

    {{-- NOTIFIKASI PENTING (TOAST) --}}
    @if(session('notif'))
      <div class="toast show position-fixed top-0 end-0 m-4 bg-danger text-white" style="z-index:9999;">
        <div class="toast-body">
          {{ session('notif') }}
        </div>
      </div>
    @endif

    {{-- STATUS MEJA --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="dashboard-box d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-gold mb-2">Status Meja</h5>
                    <div>Meja tersedia: <b>{{ $mejaTersedia ?? 0 }}</b> dari <b>{{ $totalMeja ?? 0 }}</b></div>
                </div>
                <a href="{{ route('tables.index') }}" class="btn btn-cafe">Lihat Daftar Meja</a>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="dashboard-box">
                <h5 class="fw-bold text-gold mb-2">Menu Terlaris</h5>
                {{-- Chart.js atau data menu terlaris --}}
                <canvas id="topMenuChart" height="80"></canvas>
            </div>
        </div>
    </div>

    {{-- GRAFIK STATISTIK --}}
    <div class="dashboard-box mb-4">
        <h5 class="fw-bold text-gold mb-3">Grafik Kunjungan</h5>
        <canvas id="visitChart" height="80"></canvas>
    </div>

    {{-- FILTER & SEARCH BAR + AUTOCOMPLETE --}}
    <div class="dashboard-box mb-4">
        <form class="row g-2 align-items-end mb-3" method="GET" action="#">
            <div class="col-md-4">
                <input class="form-control bg-glass text-white border-0" id="search" type="search" name="q" placeholder="Cari order, pelanggan, menu..." aria-label="Cari" autocomplete="off">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control bg-glass text-white border-0" id="tanggal" name="tanggal" placeholder="Tanggal">
            </div>
            <div class="col-md-2">
                <select class="form-select bg-glass text-white border-0" id="status" name="status">
                    <option value="">Pilih Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="diproses">Diproses</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select bg-glass text-white border-0" id="meja" name="meja">
                    <option value="">Pilih Meja</option>
                    <option value="1">Meja 1</option>
                    <option value="2">Meja 2</option>
                    <option value="3">Meja 3</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-cafe w-100" type="submit">Filter</button>
            </div>
        </form>
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('orders.create') }}" class="btn btn-cafe"><i class="fas fa-plus"></i> Buat Order Baru</a>
            <a href="{{ route('menu_items.create') }}" class="btn btn-cafe"><i class="fas fa-plus"></i> Tambah Menu Baru</a>
            <a href="{{ route('promotions.create') }}" class="btn btn-cafe"><i class="fas fa-plus"></i> Tambah Promosi</a>
            <a href="#" class="btn btn-cafe"><i class="fas fa-print"></i> Cetak Laporan Harian</a>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>NO. ORDER</th>
                        <th>PELANGGAN</th>
                        <th>STATUS</th>
                        <th>WAKTU</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        @php
                            $statusMap = [
                                'Selesai' => ['icon' => '✔️', 'class' => 'bg-green-600'],
                                'Diproses' => ['icon' => '🔄', 'class' => 'bg-yellow-500 text-black'],
                                'Dibatalkan' => ['icon' => '❌', 'class' => 'bg-red-600'],
                            ];
                            $status = $activity->status;
                            $icon = $statusMap[$status]['icon'] ?? '';
                            $class = $statusMap[$status]['class'] ?? 'bg-gray-500';
                        @endphp
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-4 py-3">#{{ $activity->order_id }}</td>
                            <td class="px-4 py-3">{{ $activity->customer_name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $class }}">
                                    {{ $icon }} {{ $status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $activity->created_at->format('d M Y - H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex gap-2 mt-2">
            <a href="{{ route('export.excel') }}" class="btn btn-gold"><i class="fas fa-file-excel"></i> Export Excel</a>
            <a href="{{ route('export.pdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
        </div>
    </div>

    {{-- INFO CARDS: STOK & PROMO --}}
    <div class="row">
        <div class="col-md-6">
            <div class="dashboard-box">
                <h6 class="fw-bold text-gold mb-2">Stok Menu Hampir Habis</h6>
                @forelse ($lowStockMenus as $menu)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                        <span class="truncate">{{ $menu->name }}</span>
                        <span class="text-yellow-400 font-bold">Sisa: {{ $menu->stok }}</span>
                    </div>
                @empty
                    <div class="text-muted">Semua stok aman.</div>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <div class="dashboard-box">
                <h6 class="fw-bold text-gold mb-2">Menu Sedang Promo</h6>
                @forelse ($promoMenus as $promo)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                        <span class="truncate">{{ $promo->name }}</span>
                        <span class="fw-bold text-success truncate">{{ $promo->label_promo }}</span>
                    </div>
                @empty
                    <div class="text-muted">Tidak ada promo aktif.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Select2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Chart.js
    const kunjunganData = @json($kunjunganData ?? ['labels'=>[], 'datasets'=>[]]);
    const menuTerlarisData = @json($menuTerlarisData ?? ['labels'=>[], 'datasets'=>[]]);
    if(document.getElementById('visitChart')) {
      new Chart(document.getElementById('visitChart'), {
        type: 'line', data: kunjunganData, options: { responsive: true }
      });
    }
    if(document.getElementById('topMenuChart')) {
      new Chart(document.getElementById('topMenuChart'), {
        type: 'bar', data: menuTerlarisData, options: { responsive: true }
      });
    }
    // Select2
    $(document).ready(function() {
        $('.select2').select2({ theme: 'classic', width: 'resolve' });
    });
    // Validasi tanggal
    $('form').on('submit', function(e) {
        var tanggal = $('#tanggal').val();
        if (tanggal && !/^\d{4}-\d{2}-\d{2}$/.test(tanggal)) {
            alert('Format tanggal salah!');
            e.preventDefault();
        }
    });
    // Autocomplete Search
    $('#search').on('input', function() {
      let q = $(this).val();
      if(q.length < 2) { $('#suggestions').hide(); return; }
      $.get('/search-suggest', {q}, function(data) {
        let html = '';
        data.forEach(item => html += `<li class="list-group-item">${item}</li>`);
        $('#suggestions').html(html).show();
      });
    });
    $(document).on('click', '#suggestions li', function() {
      $('#search').val($(this).text());
      $('#suggestions').hide();
    });
    // Hide suggestions on click outside
    $(document).on('click', function(e) {
      if(!$(e.target).closest('#search, #suggestions').length) $('#suggestions').hide();
    });
    // Dark/Light Toggle
    const themeSwitch = document.getElementById('themeSwitch');
    if(themeSwitch) {
      themeSwitch.checked = localStorage.getItem('theme') === 'light';
      themeSwitch.addEventListener('change', function() {
        if(this.checked) {
          document.body.classList.remove('dark');
          document.body.classList.add('light');
          localStorage.setItem('theme', 'light');
        } else {
          document.body.classList.remove('light');
          document.body.classList.add('dark');
          localStorage.setItem('theme', 'dark');
        }
      });
    }
</script>
@endpush
