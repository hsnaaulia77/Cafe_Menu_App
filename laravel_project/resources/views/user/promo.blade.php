@extends('layouts.guest')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
<style>
    body, html {
        background: linear-gradient(135deg, #18181c 0%, #232526 100%) !important;
        color: #ffd700 !important;
        font-family: 'Montserrat', 'Lato', sans-serif !important;
        min-height: 100vh;
    }
    .promo-header {
        width: 100%;
        padding: 36px 0 18px 0;
        text-align: center;
        background: transparent;
    }
    .promo-header-logo {
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
    .promo-header-desc {
        color: #e0b873;
        font-size: 1.15rem;
        margin-top: 0.5rem;
        font-family: 'Lato', sans-serif;
        opacity: 0.92;
    }
    .promo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
        justify-items: center;
        margin: 0 auto 48px auto;
        max-width: 1100px;
        padding: 0 16px;
    }
    .promo-card {
        background: rgba(30,30,35,0.75);
        border-radius: 1.3rem;
        box-shadow: 0 6px 32px #0007;
        border: 1.5px solid #ffd70033;
        width: 100%;
        max-width: 400px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 16px;
        position: relative;
        transition: box-shadow 0.25s, transform 0.25s, background 0.25s;
        backdrop-filter: blur(6px);
        padding: 2.2rem 1.3rem 1.5rem 1.3rem;
        color: #ffd700;
        font-family: 'Montserrat', 'Lato', sans-serif;
    }
    .promo-title {
        color: #ffd700;
        font-weight: 700;
        font-size: 1.28rem;
        margin-bottom: 8px;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 0.5px;
    }
    .promo-desc {
        color: #fff;
        font-size: 1.01rem;
        margin-bottom: 10px;
        text-align: left;
        font-family: 'Lato', sans-serif;
        opacity: 0.93;
    }
    .promo-info {
        color: #e0b873;
        font-size: 1.05rem;
        margin-bottom: 6px;
        font-family: 'Montserrat', sans-serif;
    }
    .promo-badge {
        background: linear-gradient(90deg, #ffd700 0%, #b87333 100%);
        color: #18181c;
        font-weight: 700;
        border-radius: 1rem;
        font-size: 0.95rem;
        padding: 0.25rem 0.8rem;
        margin-right: 8px;
        font-family: 'Montserrat', sans-serif;
        display: inline-block;
    }
    .promo-footer {
        width: 100%;
        text-align: center;
        color: #ffd700;
        font-size: 1rem;
        padding: 32px 0 18px 0;
        margin-top: 32px;
        opacity: 0.7;
        font-family: 'Montserrat', sans-serif;
    }
    .promo-card {
        transition: box-shadow 0.25s, transform 0.25s, background 0.25s;
    }
    .promo-card:hover {
        box-shadow: 0 12px 36px #ffd70099;
        transform: scale(1.04) translateY(-4px);
        background: linear-gradient(120deg, #232526 60%, #b87333 100%);
    }
    .promo-badge-baru {
        background:#ff4; color:#232526; margin-left:8px; font-weight:700; border-radius:1rem; font-size:0.95rem; padding:0.25rem 0.8rem; display:inline-block;
    }
    .order-back.modern {
        background: rgba(30,30,35,0.82);
        border: 1.5px solid #ffd70055;
        color: #ffd700;
        font-weight: 700;
        border-radius: 1.2rem;
        font-size: 1.13rem;
        padding: 12px 32px;
        box-shadow: 0 2px 12px #ffd70033;
        transition: box-shadow 0.22s, background 0.22s, color 0.22s, transform 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        margin-top: 0.5em;
    }
    .order-back.modern:hover {
        background: linear-gradient(90deg,#ffd700 0%,#b87333 100%);
        color: #18181c;
        box-shadow: 0 6px 24px #ffd70099;
        transform: translateY(-2px) scale(1.05);
    }
    @media (max-width: 900px) {
        .promo-header-logo { font-size: 1.5rem; }
        .promo-grid { grid-template-columns: 1fr; gap: 18px; padding: 0 2px; }
        .promo-card { max-width: 98vw; }
        .order-back.modern { font-size: 1rem; padding: 10px 18px; }
    }
    @media (max-width: 600px) {
        .promo-header-logo { font-size: 1.1rem; }
        .promo-card { padding: 1.2rem 0.7rem 1.5rem 0.7rem; }
        .order-back.modern { font-size: 0.95rem; padding: 8px 10px; }
    }
</style>
<div class="promo-header">
    <div class="promo-header-logo">
        <i class="fas fa-gift"></i> Promo CafeKu
    </div>
    <div class="promo-header-desc">Daftar promo menarik yang sedang berlaku di CafeKu.</div>
</div>
<div style="width:100%;text-align:center;margin-bottom:18px;">
    <a href="javascript:history.back()" class="order-back modern"><i class="fas fa-arrow-left" style="font-size:1.25em;"></i> Kembali</a>
</div>
<div style="text-align:center; margin-bottom:18px;">
    <select id="filterJenisPromo" style="padding:8px 12px; border-radius:8px; border:1px solid #ffd700; font-size:1rem; margin-right:10px;">
        <option value="">Semua Jenis Promo</option>
        <option value="diskon">Diskon Persen</option>
        <option value="potongan">Potongan Harga</option>
        <option value="voucher">Ada Kode Voucher</option>
        <option value="tanpa_voucher">Tanpa Kode Voucher</option>
    </select>
    <input type="text" id="searchPromo" placeholder="Cari promo..." style="padding:8px 16px; border-radius:8px; border:1px solid #ffd700; width:220px; font-size:1rem;">
</div>
@php
    $promos = \App\Models\Promotion::where('status','aktif')
        ->where(function($q){
            $q->whereNull('tanggal_berakhir')
              ->orWhere('tanggal_berakhir', '>=', now());
        })
        ->orderByDesc('tanggal_mulai')->get();
@endphp
<div class="promo-grid">
    @forelse($promos as $promo)
        @php
            $isBaru = \Carbon\Carbon::parse($promo->tanggal_mulai)->gt(now()->subDays(7));
        @endphp
        <div class="promo-card" data-nama="{{ strtolower($promo->nama) }}" data-deskripsi="{{ strtolower($promo->deskripsi) }}" data-kode="{{ strtolower($promo->kode_voucher ?? '') }}" data-diskon="{{ $promo->diskon_persen ? '1' : '0' }}" data-potongan="{{ $promo->potongan_harga ? '1' : '0' }}" data-voucher="{{ $promo->kode_voucher ? '1' : '0' }}">
            <div class="promo-title">{{ $promo->nama }}
                @if($isBaru)
                    <span class="promo-badge-baru">Promo Terbaru</span>
                @endif
            </div>
            <div class="promo-desc">{{ $promo->deskripsi }}</div>
            <div class="promo-info"><b>Kode Voucher:</b> <span class="promo-badge">{{ $promo->kode_voucher ?? '-' }}</span></div>
            <div class="promo-info"><b>Diskon:</b> {{ $promo->diskon_persen ? $promo->diskon_persen.'%' : '-' }}</div>
            <div class="promo-info"><b>Potongan Harga:</b> {{ $promo->potongan_harga ? 'Rp '.number_format($promo->potongan_harga) : '-' }}</div>
            <div class="promo-info"><b>Tanggal:</b> {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</div>
            <div class="promo-info"><b>Menu Berlaku:</b> 
                @if($promo->menuItems && $promo->menuItems->count())
                    @foreach($promo->menuItems as $menu)
                        <span class="promo-badge">{{ $menu->nama }}</span>
                    @endforeach
                @elseif(!empty($promo->menu_berlaku_manual))
                    <span class="promo-badge">{{ $promo->menu_berlaku_manual }}</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </div>
            <button class="btn btn-main" style="margin-top:14px; font-size:1rem; padding:8px 22px;" onclick="showPromoDetail({{ $promo->id }})">Lihat Detail</button>
            <div class="promo-detail-data" style="display:none;">
                <div style="font-size:1.15rem; font-weight:700; color:#ffd700; margin-bottom:8px;">{{ $promo->nama }}</div>
                <div style="color:#fff; margin-bottom:8px;">{{ $promo->deskripsi }}</div>
                <div style="color:#e0b873; margin-bottom:6px;"><b>Kode Voucher:</b> {{ $promo->kode_voucher ?? '-' }}</div>
                <div style="color:#e0b873; margin-bottom:6px;"><b>Diskon:</b> {{ $promo->diskon_persen ? $promo->diskon_persen.'%' : '-' }}</div>
                <div style="color:#e0b873; margin-bottom:6px;"><b>Potongan Harga:</b> {{ $promo->potongan_harga ? 'Rp '.number_format($promo->potongan_harga) : '-' }}</div>
                <div style="color:#e0b873; margin-bottom:6px;"><b>Tanggal:</b> {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</div>
                <div style="color:#e0b873; margin-bottom:6px;"><b>Menu Berlaku:</b> 
                    @if($promo->menuItems && $promo->menuItems->count())
                        @foreach($promo->menuItems as $menu)
                            <span class="promo-badge">{{ $menu->nama }}</span>
                        @endforeach
                    @elseif(!empty($promo->menu_berlaku_manual))
                        <span class="promo-badge">{{ $promo->menu_berlaku_manual }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
                <div style="color:#fff; margin-top:10px; font-size:0.98rem;">Syarat & Ketentuan berlaku. Promo hanya berlaku selama periode aktif.</div>
            </div>
        </div>
    @empty
        <div class="promo-card" style="text-align:center;">Belum ada promo aktif saat ini.</div>
    @endforelse
</div>
<!-- Modal Detail Promo -->
<div id="modalPromoDetail" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(24,24,28,0.85); align-items:center; justify-content:center;">
    <div id="modalPromoContent" style="background:#232526; border-radius:1.2rem; padding:32px 24px; min-width:320px; max-width:90vw; box-shadow:0 8px 32px #000a; position:relative; color:#ffd700;">
        <button onclick="closePromoDetail()" style="position:absolute; top:12px; right:18px; background:none; border:none; color:#ffd700; font-size:1.5rem; cursor:pointer;">&times;</button>
        <div id="modalPromoBody"></div>
    </div>
</div>
<script>
// Gabungan filter dan search
const searchInput = document.getElementById('searchPromo');
const filterJenis = document.getElementById('filterJenisPromo');
function filterPromo() {
    const val = searchInput.value.toLowerCase();
    const jenis = filterJenis.value;
    document.querySelectorAll('.promo-card').forEach(function(card) {
        let show = true;
        // Filter jenis promo
        if (jenis === 'diskon') show = card.getAttribute('data-diskon') === '1';
        if (jenis === 'potongan') show = card.getAttribute('data-potongan') === '1';
        if (jenis === 'voucher') show = card.getAttribute('data-voucher') === '1';
        if (jenis === 'tanpa_voucher') show = card.getAttribute('data-voucher') === '0';
        // Filter search
        const nama = card.getAttribute('data-nama') || '';
        const desk = card.getAttribute('data-deskripsi') || '';
        const kode = card.getAttribute('data-kode') || '';
        if (show) show = (nama.includes(val) || desk.includes(val) || kode.includes(val));
        card.style.display = show ? '' : 'none';
    });
}
searchInput.addEventListener('input', filterPromo);
filterJenis.addEventListener('change', filterPromo);
// Modal detail promo
function showPromoDetail(id) {
    const card = Array.from(document.querySelectorAll('.promo-card')).find(c => c.querySelector('button').getAttribute('onclick').includes('('+id+')'));
    if (!card) return;
    const detail = card.querySelector('.promo-detail-data').innerHTML;
    document.getElementById('modalPromoBody').innerHTML = detail;
    document.getElementById('modalPromoDetail').style.display = 'flex';
}
function closePromoDetail() {
    document.getElementById('modalPromoDetail').style.display = 'none';
}
document.getElementById('modalPromoDetail').addEventListener('click', function(e) {
    if (e.target === this) closePromoDetail();
});
</script>
<div class="promo-footer">
    &copy; {{ date('Y') }} CafeKu. All rights reserved.
</div>
@endsection 