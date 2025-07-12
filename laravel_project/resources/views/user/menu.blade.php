@extends('layouts.menu')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
<style>
    body, html {
        background: linear-gradient(135deg, #18181c 0%, #232526 100%) !important;
        color: #fff !important;
        font-family: 'Montserrat', 'Lato', sans-serif !important;
        min-height: 100vh;
    }
    .menu-header {
        width: 100%;
        padding: 36px 0 18px 0;
        text-align: center;
        background: transparent;
    }
    .menu-header-logo {
        font-size: 2.5rem;
        color: #ffd700;
        font-family: 'Montserrat', sans-serif;
        font-weight: bold;
        letter-spacing: 2px;
        text-shadow: 0 2px 16px #b8733340;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    .menu-header-desc {
        color: #e0b873;
        font-size: 1.15rem;
        margin-top: 0.5rem;
        font-family: 'Lato', sans-serif;
        opacity: 0.92;
    }
    .menu-filter-bar {
        position: sticky;
        top: 0;
        z-index: 20;
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        justify-content: center;
        align-items: center;
        margin: 0 auto 32px auto;
        max-width: 1100px;
        font-family: 'Montserrat', 'Lato', sans-serif;
        background: rgba(30,30,35,0.95);
        border-radius: 1.2rem;
        box-shadow: 0 2px 16px #0005;
        padding: 18px 24px;
        backdrop-filter: blur(4px);
    }
    .category-icon-btn {
        background: none;
        border: none;
        color: #ffd700;
        font-size: 1.6rem;
        margin: 0 4px;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        border-radius: 50%;
        padding: 7px 10px;
        outline: none;
        position: relative;
    }
    .category-icon-btn.selected, .category-icon-btn:hover {
        color: #18181c;
        background: linear-gradient(90deg, #ffd700 0%, #b87333 100%);
        transform: scale(1.13);
    }
    .price-slider {
        width: 180px;
        accent-color: #ffd700;
        margin: 0 8px;
    }
    .price-slider-label {
        color: #ffd700;
        font-size: 1.05rem;
        margin-right: 6px;
        font-weight: 600;
    }
    .search-input {
        padding: 13px 22px;
        border-radius: 1rem;
        border: 1.5px solid #ffd70033;
        background: rgba(24,24,28,0.95);
        color: #ffd700;
        font-size: 1.1rem;
        min-width: 180px;
        outline: none;
        font-weight: 600;
        font-family: 'Montserrat', 'Lato', sans-serif;
        transition: border 0.2s, box-shadow 0.2s;
    }
    .search-input:focus {
        border: 1.5px solid #ffd700;
        box-shadow: 0 2px 12px #ffd70033;
    }
    .menu-filter-bar select, .menu-filter-bar input[type="text"] {
        padding: 13px 22px;
        border-radius: 1rem;
        border: 1.5px solid #ffd70033;
        background: rgba(24,24,28,0.95);
        color: #ffd700;
        font-size: 1.1rem;
        min-width: 140px;
        outline: none;
        font-weight: 600;
        font-family: 'Montserrat', 'Lato', sans-serif;
        transition: border 0.2s, box-shadow 0.2s;
    }
    .menu-filter-bar select:focus, .menu-filter-bar input[type="text"]:focus {
        border: 1.5px solid #ffd700;
        box-shadow: 0 2px 12px #ffd70033;
    }
    .menu-filter-bar input[type="text"]::placeholder {
        color: #ffd70099;
    }
    .menu-filter-bar label {
        color: #ffd700;
        font-size: 1.1rem;
        margin-left: 8px;
        margin-right: 4px;
        font-weight: 600;
        font-family: 'Montserrat', 'Lato', sans-serif;
    }
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 36px;
        justify-items: center;
        margin: 0 auto 48px auto;
        max-width: 1200px;
        padding: 0 16px;
    }
    .menu-card {
        background: rgba(30,30,35,0.65);
        border-radius: 1.3rem;
        box-shadow: 0 6px 32px #0007;
        border: 1.5px solid #ffd70033;
        width: 100%;
        max-width: 320px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 16px;
        position: relative;
        transition: box-shadow 0.25s, transform 0.25s, background 0.25s;
        backdrop-filter: blur(6px);
    }
    .menu-card:hover {
        box-shadow: 0 12px 48px #ffd70055;
        transform: translateY(-6px) scale(1.045);
        background: rgba(30,30,35,0.82);
    }
    .menu-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: #232526;
        cursor: pointer;
        transition: filter 0.25s, box-shadow 0.25s;
        border-top-left-radius: 1.3rem;
        border-top-right-radius: 1.3rem;
    }
    .menu-img:hover {
        filter: brightness(1.12) contrast(1.13);
        box-shadow: 0 8px 32px #ffd70080;
    }
    .menu-img.zoomable {
        cursor: zoom-in;
        transition: filter 0.25s, box-shadow 0.25s, transform 0.25s;
    }
    .menu-img.zoomable:active {
        transform: scale(1.12);
        filter: brightness(1.18) contrast(1.18);
        z-index: 10;
    }
    .menu-title {
        color: #ffd700;
        font-weight: 700;
        font-size: 1.28rem;
        margin: 14px 0 4px 0;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 0.5px;
    }
    .menu-price {
        color: #b87333;
        font-size: 1.13rem;
        font-weight: 600;
        margin-bottom: 8px;
        font-family: 'Montserrat', sans-serif;
    }
    .menu-desc {
        color: #fff;
        font-size: 1.01rem;
        margin-bottom: 14px;
        text-align: center;
        min-height: 48px;
        font-family: 'Lato', sans-serif;
        opacity: 0.93;
    }
    .menu-rating {
        margin-bottom: 6px;
        text-align: center;
        font-size: 1.08rem;
        letter-spacing: 0.1em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-pesan {
        background: linear-gradient(90deg, #ffd700 0%, #b87333 100%) !important;
        color: #18181c !important;
        font-weight: 700;
        border-radius: 0.9rem;
        border: none;
        font-size: 1.13rem;
        box-shadow: 0 2px 12px #b8733340;
        transition: box-shadow 0.22s, transform 0.22s, background 0.22s;
        margin-bottom: 18px;
        padding: 12px 36px;
        text-decoration: none;
        display: inline-block;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }
    .btn-pesan:hover {
        box-shadow: 0 8px 32px #ffd70080;
        transform: translateY(-2px) scale(1.06);
        color: #18181c !important;
        background: linear-gradient(90deg, #b87333 0%, #ffd700 100%) !important;
        animation: bounce 0.3s;
    }
    @keyframes bounce {
        0% { transform: scale(1); }
        50% { transform: scale(1.09); }
        100% { transform: scale(1.06); }
    }
    .badge-promo {
        background: linear-gradient(90deg, #ffd700 0%, #b87333 100%);
        color: #18181c;
        font-weight: 700;
        border-radius: 1rem;
        font-size: 0.95rem;
        padding: 0.25rem 0.8rem;
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 2;
        box-shadow: 0 2px 8px #b8733340;
        font-family: 'Montserrat', sans-serif;
        animation: promo-glow 1.5s infinite alternate;
    }
    @keyframes promo-glow {
        0% { box-shadow: 0 0 8px #ffd70080; }
        100% { box-shadow: 0 0 24px #ffd700cc; }
    }
    .menu-placeholder {
        color: #ffd700;
        font-size: 1.3rem;
        grid-column: 1/-1;
        margin-top: 36px;
        display: flex;
        flex-direction: column;
        align-items: center;
        opacity: 0.88;
        font-family: 'Montserrat', sans-serif;
    }
    .menu-placeholder svg {
        width: 80px;
        height: 80px;
        margin-bottom: 12px;
        opacity: 0.7;
        display: block;
    }
    .modal-content, .modal-form input, .modal-form textarea, .modal-form label, .modal-form button {
        font-family: 'Montserrat', 'Lato', sans-serif !important;
    }
    .menu-footer {
        width: 100%;
        text-align: center;
        color: #ffd700;
        font-size: 1rem;
        padding: 32px 0 18px 0;
        margin-top: 32px;
        opacity: 0.7;
        font-family: 'Montserrat', sans-serif;
    }
    .btn-quickadd {
        background: #ffd700;
        color: #18181c;
        border: none;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px #b8733340;
        transition: box-shadow 0.18s, transform 0.18s, background 0.18s;
        cursor: pointer;
    }
    .btn-quickadd:hover {
        background: #b87333;
        color: #ffd700;
        transform: scale(1.12);
        box-shadow: 0 4px 16px #ffd70080;
    }
</style>
<div class="menu-header">
    <div class="menu-header-logo">
        <i class="fas fa-coffee"></i> CafeKu
    </div>
    <div class="menu-header-desc">Daftar menu andalan cafe kami.</div>
</div>
@php
    use App\Models\MenuItem;
    use App\Models\Category;
    $kategori_id = request('kategori_id');
    $q = request('q');
    $sort = request('sort');
    $promo = request('promo');
    $min_price = request('min_price');
    $max_price = request('max_price');
    $categories = Category::where('status', 'aktif')->orderBy('name')->get();
    $minHarga = MenuItem::where('status','aktif')->min('harga') ?? 0;
    $maxHarga = MenuItem::where('status','aktif')->max('harga') ?? 100000;
    $menus = MenuItem::where('status', 'aktif')
        ->when($kategori_id, fn($query) => $query->where('kategori_id', $kategori_id))
        ->when($q, fn($query) => $query->where('nama', 'like', "%$q%"))
        ->when($promo, fn($query) => $query->whereHas('promotions', fn($q) => $q->where('status','aktif')))
        ->when($min_price, fn($query) => $query->where('harga', '>=', $min_price))
        ->when($max_price, fn($query) => $query->where('harga', '<=', $max_price))
        ->when($sort == 'termurah', fn($query) => $query->orderBy('harga'))
        ->when($sort == 'termahal', fn($query) => $query->orderByDesc('harga'))
        ->when(!$sort, fn($query) => $query->orderByDesc('created_at'))
        ->get();
    $menusArr = $menus->map(function($m){
        $avgRating = $m->reviews()->avg('rating');
        $reviewCount = $m->reviews()->count();
        return [
            'id'=>$m->id,
            'nama'=>$m->nama,
            'harga'=>$m->harga,
            'deskripsi'=>$m->deskripsi,
            'gambar'=>$m->gambar ? asset('storage/'.$m->gambar) : 'https://via.placeholder.com/400x180?text=Menu',
            'promo'=>$m->promotions()->where('status','aktif')->count() ? true : false,
            'promo_label'=>$m->promotions()->where('status','aktif')->first()?->nama,
            'promo_desc'=>$m->promotions()->where('status','aktif')->first()?->deskripsi,
            'avg_rating'=>round($avgRating,1),
            'review_count'=>$reviewCount,
        ];
    });
    // Hapus mapping $categoryIcons, ambil icon dari $cat->icon
@endphp
<!-- noUiSlider CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css">
<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
<form method="get" class="menu-filter-bar mb-4" id="filterBar">
    <div style="display:flex;gap:8px;align-items:center;">
        <button type="submit" name="kategori_id" value="" class="category-icon-btn {{ !$kategori_id ? 'selected' : '' }}" title="Semua Kategori"><i class="fas fa-th-large"></i></button>
        @foreach($categories as $cat)
            @php
                $icon = $cat->icon ?: 'fa-ellipsis-h';
            @endphp
            <button type="submit" name="kategori_id" value="{{ $cat->id }}" class="category-icon-btn {{ $kategori_id == $cat->id ? 'selected' : '' }}" title="{{ $cat->name }}"><i class="fas {{ $icon }}"></i></button>
        @endforeach
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
        <span class="price-slider-label">Harga</span>
        <div id="slider-harga" style="width:200px;margin:0 8px;"></div>
        <span id="minPriceVal">{{ $min_price ?? $minHarga }}</span>
        <span style="color:#ffd700;">-</span>
        <span id="maxPriceVal">{{ $max_price ?? $maxHarga }}</span>
        <input type="hidden" name="min_price" id="min_price_input" value="{{ $min_price ?? $minHarga }}">
        <input type="hidden" name="max_price" id="max_price_input" value="{{ $max_price ?? $maxHarga }}">
    </div>
    <input type="text" name="q" value="{{ $q }}" placeholder="Cari menu..." class="search-input" onkeydown="if(event.key==='Enter'){this.form.submit();}">
    <select name="sort" onchange="this.form.submit()">
        <option value="">Urutkan</option>
        <option value="termurah" {{ $sort=='termurah' ? 'selected' : '' }}>Harga Termurah</option>
        <option value="termahal" {{ $sort=='termahal' ? 'selected' : '' }}>Harga Termahal</option>
    </select>
    <label><input type="checkbox" name="promo" value="1" onchange="this.form.submit()" {{ $promo ? 'checked' : '' }}> Hanya menu promo</label>
    <button type="submit" style="display:none">Cari</button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var slider = document.getElementById('slider-harga');
    if(slider && window.noUiSlider) {
        var minHarga = {{ $minHarga }};
        var maxHarga = {{ $maxHarga }};
        var startMin = {{ $min_price ?? $minHarga }};
        var startMax = {{ $max_price ?? $maxHarga }};
        noUiSlider.create(slider, {
            start: [startMin, startMax],
            connect: true,
            step: 1000,
            range: {
                'min': minHarga,
                'max': maxHarga
            },
            tooltips: [true, true],
            format: {
                to: function (value) { return Math.round(value); },
                from: function (value) { return Number(value); }
            }
        });
        slider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('minPriceVal').innerText = values[0];
            document.getElementById('maxPriceVal').innerText = values[1];
            document.getElementById('min_price_input').value = values[0];
            document.getElementById('max_price_input').value = values[1];
        });
    }
});
// Sticky polyfill for Safari/iOS
window.addEventListener('scroll', function() {
    var bar = document.getElementById('filterBar');
    if(bar) {
        if(window.scrollY > 0) bar.classList.add('scrolled');
        else bar.classList.remove('scrolled');
    }
});
</script>
<div class="menu-grid">
    @forelse($menus as $menu)
        <div class="menu-card">
            @if($menu->promotions()->where('status','aktif')->count())
                <span class="badge-promo">Promo</span>
            @endif
            <img class="menu-img zoomable" src="{{ $menu->gambar ? asset('storage/'.$menu->gambar) : 'https://via.placeholder.com/400x180?text=Menu' }}" alt="{{ $menu->nama }}" onclick="showDetail({{ $menu->id }})">
            <div class="menu-title">{{ $menu->nama }}</div>
            <div class="menu-rating">
                @php
                    $avg = round($menu->reviews()->avg('rating'),1);
                    $count = $menu->reviews()->count();
                @endphp
                <span style="color:#ffd700;">
                    @for($i=1;$i<=5;$i++)
                        @if($i <= floor($avg))<i class="fas fa-star"></i>@elseif($i-$avg<=0.5)<i class="fas fa-star-half-alt"></i>@else<i class="far fa-star"></i>@endif
                    @endfor
                </span>
                <span style="color:#e0b873;font-size:0.98rem;">{{ $avg>0?$avg:'-' }} ({{ $count }})</span>
            </div>
            <div class="menu-price">Rp{{ number_format($menu->harga,0,',','.') }}</div>
            <div class="menu-desc">{{ $menu->deskripsi }}</div>
            <div style="display:flex;gap:8px;justify-content:center;align-items:center;width:100%;">
                <button class="btn-pesan" onclick="showOrder({{ $menu->id }})" type="button">Pesan</button>
                <button class="btn-quickadd" onclick="quickAdd({{ $menu->id }})" title="Tambah cepat"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    @empty
        <div class="menu-placeholder">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="32" cy="56" rx="24" ry="6" fill="#b87333" fill-opacity="0.18"/><rect x="16" y="28" width="32" height="18" rx="6" fill="#232526" stroke="#ffd700" stroke-width="2"/><ellipse cx="32" cy="28" rx="16" ry="6" fill="#ffd700" fill-opacity="0.7"/><ellipse cx="32" cy="28" rx="14" ry="4" fill="#fff" fill-opacity="0.15"/><ellipse cx="32" cy="28" rx="8" ry="2" fill="#fff" fill-opacity="0.08"/></svg>
            Belum ada menu tersedia.<br>Silakan kembali lagi nanti!
        </div>
    @endforelse
</div>
<!-- Modal Detail Menu -->
<div id="modal-detail" style="display:none;"></div>
<!-- Modal Order -->
<div id="modal-order" style="display:none;"></div>
<div class="menu-footer">
    &copy; {{ date('Y') }} CafeKu. All rights reserved.
</div>
<script>
    const menus = @json($menusArr);
    function showDetail(id) {
        const m = menus.find(x=>x.id===id);
        if(!m) return;
        let promo = m.promo ? `<div class='badge-promo' style='position:static;display:inline-block;margin-bottom:8px;'>Promo: ${m.promo_label||''}</div><div style='color:#ffd700;font-size:1rem;margin-bottom:8px;'>${m.promo_desc||''}</div>` : '';
        document.getElementById('modal-detail').innerHTML = `
        <div class='modal-bg' onclick='closeModal("modal-detail")'>
            <div class='modal-content' onclick='event.stopPropagation()'>
                <span class='modal-close' onclick='closeModal("modal-detail")'>&times;</span>
                <img class='modal-img' src='${m.gambar}' alt='${m.nama}'>
                <div class='modal-label'>${m.nama}</div>
                <div style='color:#b87333;font-size:1.1rem;font-weight:600;margin-bottom:8px;'>Rp${m.harga.toLocaleString('id-ID')}</div>
                <div style='color:#fff;margin-bottom:12px;'>${m.deskripsi}</div>
                ${promo}
                <button class='btn-pesan' onclick='showOrder(${m.id})'>Pesan</button>
            </div>
        </div>`;
        document.getElementById('modal-detail').style.display = 'block';
    }
    function showOrder(id) {
        const m = menus.find(x=>x.id===id);
        if(!m) return;
        document.getElementById('modal-order').innerHTML = `
        <div class='modal-bg' onclick='closeModal("modal-order")'>
            <form class='modal-content modal-form' method='POST' action='{{ url('/order') }}' onclick='event.stopPropagation()'>
                @csrf
                <span class='modal-close' onclick='closeModal("modal-order")'>&times;</span>
                <div class='modal-label'>Pesan: ${m.nama}</div>
                <input type='hidden' name='menu_id' value='${m.id}'>
                <label>Jumlah</label>
                <input type='number' name='jumlah' min='1' value='1' required>
                <label>Catatan</label>
                <textarea name='catatan' rows='2' placeholder='Opsional'></textarea>
                <button type='submit' class='btn-pesan'>Konfirmasi Pesan</button>
            </form>
        </div>`;
        document.getElementById('modal-order').style.display = 'block';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    function quickAdd(id) {
        // Implementasi quick add, misal: langsung submit order dengan jumlah 1
        const m = menus.find(x=>x.id===id);
        if(!m) return;
        // Bisa diganti dengan AJAX atau form tersembunyi
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ url('/order') }}";
        form.innerHTML = `@csrf<input type='hidden' name='menu_id' value='${m.id}'><input type='hidden' name='jumlah' value='1'>`;
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection 