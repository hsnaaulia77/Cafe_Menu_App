<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeKu - Aplikasi Pemesanan Cafe</title>
    <!-- Google Fonts: Montserrat & Lato -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
    <!-- AdminLTE & FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body, html {
            min-height: 100vh;
            background: linear-gradient(135deg, #18181c 0%, #232526 100%) !important;
            color: #fff !important;
            font-family: 'Montserrat', 'Lato', sans-serif !important;
            margin: 0;
            padding: 0;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .hero-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            background: linear-gradient(135deg, #18181c 60%, #b87333 100%);
            opacity: 0.18;
        }
        .coffee-illustration {
            position: absolute;
            bottom: 0; right: 0;
            width: 340px;
            max-width: 60vw;
            opacity: 0.25;
            z-index: 1;
            pointer-events: none;
        }
        .brand-title {
            font-size: 3.5rem;
            font-weight: bold;
            color: #ffd700;
            text-shadow: 0 2px 12px #b8733340;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
            z-index: 2;
        }
        .brand-tagline {
            color: #e0b873;
            font-size: 1.5rem;
            margin-bottom: 2.2rem;
            font-family: 'Lato', sans-serif;
            text-align: center;
            max-width: 600px;
            z-index: 2;
        }
        .btn-main {
            background: linear-gradient(90deg, #ffd700 0%, #b87333 100%) !important;
            color: #18181c !important;
            font-weight: 700;
            border-radius: 0.8rem;
            border: none;
            font-size: 1.25rem;
            box-shadow: 0 2px 12px #b8733340;
            transition: box-shadow 0.2s, transform 0.2s;
            margin: 12px;
            padding: 16px 40px;
            text-decoration: none;
            display: inline-block;
            z-index: 2;
        }
        .btn-main:hover {
            box-shadow: 0 4px 24px #ffd70080;
            transform: translateY(-2px) scale(1.03);
            color: #18181c !important;
        }
        .features {
            display: flex;
            gap: 32px;
            margin-top: 48px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .feature-box {
            background: rgba(30,30,35,0.92);
            color: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px #0008;
            padding: 28px 20px 20px 20px;
            width: 260px;
            text-align: center;
            margin-bottom: 24px;
            border: 1.5px solid #ffd70033;
        }
        .feature-box h3 {
            margin-bottom: 12px;
            color: #ffd700;
            font-family: 'Montserrat', sans-serif;
        }
        .feature-box i {
            font-size: 2.2rem;
            color: #b87333;
            margin-bottom: 10px;
        }
        @media (max-width: 900px) {
            .coffee-illustration { width: 180px; }
            .brand-title { font-size: 2.2rem; }
            .brand-tagline { font-size: 1.1rem; }
            .features { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>
    <!-- HERO SECTION (hanya satu, paling atas) -->
    <style>
        .hero-bg-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') center center/cover no-repeat;
            opacity: 0.22;
            filter: blur(1.5px);
        }
        .hero-bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #18181c 60%, #232526 100%);
            opacity: 0.7;
            z-index: 1;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            z-index: 2;
            padding-top: 32px;
        }
        .brand-title {
            font-size: 3.5rem;
            font-weight: bold;
            color: #ffd700;
            text-shadow: 0 2px 12px #b8733340;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
            z-index: 3;
        }
        .brand-tagline {
            color: #e0b873;
            font-size: 1.5rem;
            margin-bottom: 2.2rem;
            font-family: 'Lato', sans-serif;
            text-align: center;
            max-width: 600px;
            z-index: 3;
            text-shadow: 0 2px 12px #18181c99;
        }
        .btn-main {
            font-size: 1.45rem !important;
            padding: 20px 56px !important;
            margin: 18px !important;
            box-shadow: 0 6px 32px #b8733340 !important;
            letter-spacing: 1px;
            z-index: 3;
        }
        .btn-main:active {
            transform: scale(0.97);
        }
        @media (max-width: 900px) {
            .btn-main { font-size: 1.1rem !important; padding: 14px 28px !important; }
            .brand-title { font-size: 2.2rem; }
            .brand-tagline { font-size: 1.1rem; }
        }
    </style>
    <div class="hero">
        <div class="hero-bg-img"></div>
        <div class="hero-bg-overlay"></div>
        <svg class="coffee-illustration" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="256" cy="480" rx="200" ry="32" fill="#b87333" fill-opacity="0.3"/>
            <path d="M120 400c0 44.2 58.8 80 136 80s136-35.8 136-80V160H120v240z" fill="#232526"/>
            <ellipse cx="256" cy="160" rx="136" ry="48" fill="#ffd700" fill-opacity="0.7"/>
            <ellipse cx="256" cy="160" rx="120" ry="36" fill="#fff" fill-opacity="0.15"/>
            <ellipse cx="256" cy="160" rx="80" ry="20" fill="#fff" fill-opacity="0.08"/>
            <path d="M392 240c44 0 80 36 80 80s-36 80-80 80" stroke="#ffd700" stroke-width="16" fill="none"/>
        </svg>
        <div class="brand-title"><i class="fas fa-coffee"></i> CafeKu</div>
        <div class="brand-tagline">
            Nikmati pengalaman <b>pemesanan cafe</b> yang <span style="color:#ffd700">mudah</span>, <span style="color:#ffd700">cepat</span>, dan <span style="color:#ffd700">nyaman</span>.<br>
            Pesan menu favoritmu tanpa antri, langsung dari aplikasi!
        </div>
        <div>
            <a href="{{ route('login') }}" class="btn-main"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
            <a href="{{ route('register') }}" class="btn-main" style="background:linear-gradient(90deg,#b87333 0%,#ffd700 100%) !important;"><i class="fas fa-user-plus me-1"></i> Daftar</a>
        </div>
    </div>

    <!-- FITUR UTAMA -->
    <style>
        .features {
            display: flex;
            gap: 32px;
            margin: 64px 0 0 0;
            justify-content: center;
            flex-wrap: wrap;
        }
        .feature-box {
            background: rgba(30,30,35,0.92);
            color: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px #0008;
            padding: 28px 20px 20px 20px;
            width: 260px;
            text-align: center;
            margin-bottom: 24px;
            border: 1.5px solid #ffd70033;
            transition: box-shadow 0.2s, transform 0.2s;
            text-decoration: none;
            position: relative;
            z-index: 2;
        }
        .feature-box:hover {
            box-shadow: 0 8px 32px #ffd70055;
            transform: translateY(-4px) scale(1.04);
        }
    </style>
    <div class="features">
        <a href="{{ route('user.menu') }}" class="feature-box">
            <i class="fas fa-utensils"></i>
            <h3>Menu Lengkap</h3>
            <p>Lihat dan pesan berbagai menu makanan & minuman cafe favoritmu.</p>
        </a>
        <a href="{{ route('user.order') }}" class="feature-box">
            <i class="fas fa-mobile-alt"></i>
            <h3>Pemesanan Mudah</h3>
            <p>Pesan dari mana saja, kapan saja, tanpa antri di kasir.</p>
        </a>
        <a href="{{ route('user.promo') }}" class="feature-box">
            <i class="fas fa-gift"></i>
            <h3>Promo Menarik</h3>
            <p>Dapatkan diskon & promo spesial setiap hari.</p>
        </a>
        <a href="{{ route('user.reservasi') }}" class="feature-box">
            <i class="fas fa-chair"></i>
            <h3>Reservasi Meja</h3>
            <p>Booking meja favoritmu secara online, tanpa perlu menunggu.</p>
        </a>
    </div>

    <!-- Tentang Kami Section -->
    <section style="width:100%; display:flex; justify-content:center; align-items:center; margin:64px 0 0 0; flex-wrap:wrap; gap:40px;">
        <div style="max-width:420px; min-width:260px; z-index:2;">
            <h2 style="color:#ffd700; font-family:'Montserrat',sans-serif; font-size:2rem; font-weight:700; margin-bottom:1rem;">Tentang Kami</h2>
            <p style="color:#fff; font-size:1.1rem; line-height:1.7; margin-bottom:1.2rem;">
                <b>CafeKu</b> adalah tempat nongkrong modern yang menggabungkan suasana nyaman, menu kekinian, dan teknologi pemesanan digital. Kami percaya bahwa setiap momen di cafe harus mudah, cepat, dan menyenangkan.
            </p>
            <ul style="color:#e0b873; font-size:1rem; margin-bottom:1.2rem; padding-left:1.2rem;">
                <li>☕ Visi: Menjadi cafe pilihan utama untuk generasi digital.</li>
                <li>🌟 Keunikan: Pemesanan tanpa antri, reservasi online, dan promo eksklusif setiap hari.</li>
            </ul>
            <p style="color:#ffd700; font-size:1rem; font-style:italic;">"Ngopi, ngobrol, dan pesan menu favoritmu, semua dalam satu aplikasi!"</p>
        </div>
        <div style="min-width:220px; max-width:340px;">
            <!-- Ilustrasi cafe SVG -->
            <svg viewBox="0 0 340 220" width="100%" height="auto" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="170" cy="210" rx="140" ry="10" fill="#b87333" fill-opacity="0.18"/>
                <rect x="60" y="100" width="220" height="60" rx="16" fill="#232526" stroke="#ffd700" stroke-width="2"/>
                <rect x="90" y="120" width="40" height="40" rx="8" fill="#b87333"/>
                <rect x="210" y="120" width="40" height="40" rx="8" fill="#b87333"/>
                <rect x="140" y="110" width="60" height="50" rx="10" fill="#ffd700" fill-opacity="0.7"/>
                <rect x="150" y="130" width="40" height="20" rx="5" fill="#fff" fill-opacity="0.15"/>
                <ellipse cx="170" cy="100" rx="60" ry="18" fill="#ffd700" fill-opacity="0.5"/>
                <ellipse cx="170" cy="100" rx="40" ry="10" fill="#fff" fill-opacity="0.08"/>
                <rect x="120" y="70" width="100" height="30" rx="10" fill="#232526" stroke="#ffd700" stroke-width="2"/>
                <ellipse cx="170" cy="70" rx="50" ry="10" fill="#ffd700" fill-opacity="0.3"/>
                <ellipse cx="170" cy="70" rx="30" ry="5" fill="#fff" fill-opacity="0.08"/>
            </svg>
        </div>
    </section>

    <!-- Galeri Menu / Cafe Section (Dinamis, 3 kolom, efek hover zoom, responsif, placeholder jika kosong) -->
    <style>
        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            justify-items: center;
            margin-top: 56px;
        }
        @media (max-width: 900px) {
            .galeri-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .galeri-grid { grid-template-columns: 1fr; }
        }
        .galeri-img {
            transition: transform 0.35s cubic-bezier(.4,2,.3,1), box-shadow 0.2s;
            will-change: transform;
        }
        .galeri-img:hover {
            transform: scale(1.08) rotate(-1deg);
            box-shadow: 0 8px 32px #ffd70055;
            z-index: 2;
        }
        .galeri-placeholder {
            background: rgba(30,30,35,0.92);
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px #0008;
            border: 1.5px solid #ffd70033;
            width: 100%;
            max-width: 260px;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffd700;
            font-size: 1.2rem;
            text-align: center;
            padding: 32px 12px;
        }
    </style>
    <section style="width:100%; max-width:1100px; margin:56px auto 0 auto; padding:0 16px;">
        <h2 style="color:#ffd700; font-family:'Montserrat',sans-serif; font-size:2rem; font-weight:700; margin-bottom:1.5rem; text-align:center;">Galeri Menu & Cafe</h2>
        @php
            use App\Models\MenuItem;
            $galeri = MenuItem::where('status', 'aktif')->orderByDesc('created_at')->limit(4)->get();
        @endphp
        <div class="galeri-grid">
            @forelse($galeri as $item)
                <div style="background:rgba(30,30,35,0.92); border-radius:1.2rem; box-shadow:0 4px 24px #0008; overflow:hidden; border:1.5px solid #ffd70033; width:100%; max-width:260px;">
                    <img class="galeri-img" src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/400x160?text=Menu' }}" alt="{{ $item->nama }}" style="width:100%; height:160px; object-fit:cover;">
                    <div style='padding:16px;'>
                        <div style='color:#ffd700; font-weight:700; font-size:1.1rem;'>{{ $item->nama }}</div>
                        <div style='color:#fff; font-size:0.98rem;'>{{ $item->deskripsi }}</div>
                    </div>
                </div>
            @empty
                <div class="galeri-placeholder">
                    <i class="fas fa-image" style="font-size:2.5rem; margin-bottom:12px;"></i>
                    Belum ada menu andalan.<br>Segera hadir menu spesial kami!
                </div>
            @endforelse
        </div>
    </section>

    <!-- Testimoni Pelanggan Section (Dinamis, slider, placeholder jika kosong) -->
    <style>
        .testi-slider {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 32px;
            scroll-snap-type: x mandatory;
            padding-bottom: 8px;
            margin-top: 56px;
        }
        .testi-card {
            flex: 0 0 270px;
            max-width: 270px;
            min-width: 220px;
            background: rgba(30,30,35,0.92);
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px #0008;
            border: 1.5px solid #ffd70033;
            padding: 28px 20px 20px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            scroll-snap-align: start;
        }
        .testi-placeholder {
            background: rgba(30,30,35,0.92);
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px #0008;
            border: 1.5px solid #ffd70033;
            min-width: 220px;
            max-width: 270px;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffd700;
            font-size: 1.1rem;
            text-align: center;
            padding: 32px 12px;
        }
    </style>
    <section style="width:100%; max-width:900px; margin:56px auto 0 auto; padding:0 16px;">
        <h2 style="color:#ffd700; font-family:'Montserrat',sans-serif; font-size:2rem; font-weight:700; margin-bottom:1.5rem; text-align:center;">Testimoni Pelanggan</h2>
        @php
            use App\Models\Review;
            $testimoni = Review::orderByDesc('tanggal')->limit(6)->get();
        @endphp
        <div class="testi-slider">
            @forelse($testimoni as $rev)
                <div class="testi-card">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($rev->nama_customer) }}&background=ffd700&color=232526&size=64" alt="{{ $rev->nama_customer }}" style="width:64px; height:64px; border-radius:50%; border:2.5px solid #ffd700; margin-bottom:12px; object-fit:cover;">
                    <div style="color:#fff; font-size:1.05rem; font-style:italic; margin-bottom:10px; text-align:center;">"{{ $rev->komentar }}"</div>
                    <div style="color:#ffd700; font-weight:700; font-size:1.05rem;">{{ $rev->nama_customer }}</div>
                    <div style="color:#ffd700; font-size:1rem;">
                        @for($i=0; $i<$rev->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                </div>
            @empty
                <div class="testi-placeholder">
                    <i class="fas fa-user-friends" style="font-size:2.2rem; margin-bottom:12px;"></i>
                    Belum ada testimoni pelanggan.<br>Jadilah yang pertama memberikan review!
                </div>
            @endforelse
        </div>
    </section>

    <!-- Promo Terbaru Section -->
    <section style="width:100%; max-width:900px; margin:56px auto 0 auto; padding:0 16px;">
        <h2 style="color:#ffd700; font-family:'Montserrat',sans-serif; font-size:2rem; font-weight:700; margin-bottom:1.5rem; text-align:center;">Promo Terbaru</h2>
        <div style="display:flex; flex-wrap:wrap; gap:32px; justify-content:center; align-items:stretch;">
            @php
                use App\Models\Promotion;
                $promos = Promotion::where('status', 'aktif')
                    ->where(function($q){
                        $q->whereNull('tanggal_berakhir')
                          ->orWhere('tanggal_berakhir', '>=', now());
                    })
                    ->orderByDesc('tanggal_mulai')
                    ->limit(3)
                    ->get();
            @endphp
            @forelse($promos as $promo)
                <div style="background:rgba(30,30,35,0.92); border-radius:1.2rem; box-shadow:0 4px 24px #0008; border:1.5px solid #ffd70033; max-width:270px; min-width:220px; padding:24px 20px 20px 20px; display:flex; flex-direction:column; align-items:center;">
                    <div style="color:#ffd700; font-weight:700; font-size:1.15rem; margin-bottom:8px;">
                        <i class="fas fa-star me-1"></i>{{ $promo->nama }}
                    </div>
                    <div style="color:#fff; font-size:1.01rem; text-align:center;">{{ $promo->deskripsi }}</div>
                    @if($promo->kode_voucher)
                        <div style="color:#b87333; font-size:0.98rem; margin-top:10px;">Kode: {{ $promo->kode_voucher }}</div>
                    @endif
                    @if($promo->diskon_persen)
                        <div style="color:#ffd700; font-size:0.98rem; margin-top:6px;">Diskon: {{ $promo->diskon_persen }}%</div>
                    @endif
                    @if($promo->potongan_harga)
                        <div style="color:#ffd700; font-size:0.98rem; margin-top:6px;">Potongan: Rp{{ number_format($promo->potongan_harga,0,',','.') }}</div>
                    @endif
                    @if($promo->tanggal_berakhir)
                        <div style="color:#fff; font-size:0.95rem; margin-top:6px;">Berlaku s/d {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</div>
                    @endif
                </div>
            @empty
                <div style='color:#fff; font-size:1.1rem; text-align:center;'>Belum ada promo aktif saat ini.</div>
            @endforelse
        </div>
    </section>

    <!-- FAQ (Pertanyaan Umum) Section: box dengan background transparan dan shadow -->
    <style>
        .faq-box details {
            background: rgba(30,30,35,0.92);
            border-radius: 1.2rem;
            border: 1.5px solid #ffd70033;
            box-shadow: 0 2px 12px #0008;
            padding: 18px 22px;
            color: #fff;
            margin-bottom: 12px;
        }
        .faq-box summary {
            color: #ffd700;
            font-weight: 700;
            font-size: 1.08rem;
            cursor: pointer;
        }
    </style>
    <section style="width:100%; max-width:800px; margin:56px auto 0 auto; padding:0 16px;">
        <h2 style="color:#ffd700; font-family:'Montserrat',sans-serif; font-size:2rem; font-weight:700; margin-bottom:1.5rem; text-align:center;">FAQ (Pertanyaan Umum)</h2>
        <div class="faq-box" style="display:flex; flex-direction:column; gap:8px;">
            <details style='background:rgba(30,30,35,0.92); border-radius:1.2rem; border:1.5px solid #ffd70033; box-shadow:0 2px 12px #0008; padding:18px 22px; color:#fff;'>
                <summary style='color:#ffd700; font-weight:700; font-size:1.08rem; cursor:pointer;'>Bagaimana cara memesan menu di CafeKu?</summary>
                <div style='margin-top:10px; font-size:1.01rem;'>
                    Anda cukup login, pilih menu favorit, lalu klik "Pesan". Pesanan Anda akan langsung diproses oleh barista kami.
                </div>
            </details>
            <details style='background:rgba(30,30,35,0.92); border-radius:1.2rem; border:1.5px solid #ffd70033; box-shadow:0 2px 12px #0008; padding:18px 22px; color:#fff;'>
                <summary style='color:#ffd700; font-weight:700; font-size:1.08rem; cursor:pointer;'>Apakah bisa reservasi meja secara online?</summary>
                <div style='margin-top:10px; font-size:1.01rem;'>
                    Ya, Anda bisa reservasi meja melalui aplikasi dan memilih waktu kedatangan sesuai keinginan.
                </div>
            </details>
            <details style='background:rgba(30,30,35,0.92); border-radius:1.2rem; border:1.5px solid #ffd70033; box-shadow:0 2px 12px #0008; padding:18px 22px; color:#fff;'>
                <summary style='color:#ffd700; font-weight:700; font-size:1.08rem; cursor:pointer;'>Metode pembayaran apa saja yang tersedia?</summary>
                <div style='margin-top:10px; font-size:1.01rem;'>
                    Kami menerima pembayaran tunai, QRIS, transfer bank, dan e-wallet (OVO, GoPay, DANA).
                </div>
            </details>
            <details style='background:rgba(30,30,35,0.92); border-radius:1.2rem; border:1.5px solid #ffd70033; box-shadow:0 2px 12px #0008; padding:18px 22px; color:#fff;'>
                <summary style='color:#ffd700; font-weight:700; font-size:1.08rem; cursor:pointer;'>Bagaimana cara mendapatkan promo atau diskon?</summary>
                <div style='margin-top:10px; font-size:1.01rem;'>
                    Promo terbaru akan selalu tampil di halaman utama aplikasi. Anda juga bisa memasukkan kode promo saat checkout.
                </div>
            </details>
        </div>
    </section>

    <!-- Kontak & Lokasi Section: box dengan background transparan dan shadow -->
    <style>
        .kontak-box {
            min-width:260px; max-width:340px; flex:1;
            background:rgba(30,30,35,0.92);
            border-radius:1.2rem;
            box-shadow:0 4px 24px #0008;
            border:1.5px solid #ffd70033;
            padding:28px 24px;
            color:#fff;
            margin-bottom: 24px;
        }
        .maps-box {
            min-width:260px; max-width:420px; flex:1;
            border-radius:1.2rem;
            overflow:hidden;
            box-shadow:0 4px 24px #0008;
            border:1.5px solid #ffd70033;
            margin-bottom: 24px;
        }
    </style>
    <section style="width:100%; max-width:1000px; margin:56px auto 0 auto; padding:0 16px;">
        <h2 style="color:#ffd700; font-family:'Montserrat',sans-serif; font-size:2rem; font-weight:700; margin-bottom:1.5rem; text-align:center;">Kontak & Lokasi</h2>
        <div style="display:flex; flex-wrap:wrap; gap:40px; justify-content:center; align-items:flex-start;">
            <div class="kontak-box">
                <div style="margin-bottom:18px;">
                    <i class="fas fa-map-marker-alt" style="color:#ffd700;"></i>
                    <span style="font-weight:700; color:#ffd700;">Alamat:</span><br>
                    Jl. Kopi No. 10, Bandung, Indonesia
                </div>
                <div style="margin-bottom:18px;">
                    <i class="fas fa-clock" style="color:#ffd700;"></i>
                    <span style="font-weight:700; color:#ffd700;">Jam Operasional:</span><br>
                    Senin - Minggu: 08.00 - 22.00 WIB
                </div>
                <div style="margin-bottom:18px;">
                    <i class="fab fa-whatsapp" style="color:#25d366;"></i>
                    <span style="font-weight:700; color:#ffd700;">Telepon/WA:</span><br>
                    <a href="https://wa.me/6281234567890" style="color:#25d366; text-decoration:none;">0812-3456-7890</a>
                </div>
                <div style="margin-bottom:10px;">
                    <span style="font-weight:700; color:#ffd700;">Media Sosial:</span><br>
                    <a href="https://instagram.com/cafeku_id" target="_blank" style="color:#ffd700; margin-right:10px;"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="https://facebook.com/cafeku.id" target="_blank" style="color:#ffd700; margin-right:10px;"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="mailto:info@cafeku.com" style="color:#ffd700;"><i class="fas fa-envelope"></i> Email</a>
                </div>
            </div>
            <div class="maps-box">
                <iframe src="https://www.google.com/maps?q=-6.914744,107.609810&z=15&output=embed" width="100%" height="260" style="border:0; border-radius:1.2rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer Section: tambah padding atas -->
    <footer style="width:100%; background:rgba(30,30,35,0.95); color:#ffd700; text-align:center; padding:38px 0 18px 0; margin-top:56px; font-family:'Montserrat',sans-serif; font-size:1rem; border-top:1.5px solid #ffd70033;">
        <div style="margin-bottom:10px;">
            &copy; {{ date('Y') }} CafeKu. All rights reserved.
            &nbsp;|&nbsp;
            <a href="#" style="color:#ffd700; text-decoration:underline;">Kebijakan Privasi</a>
        </div>
        <div style="margin-bottom:0;">
            <a href="https://instagram.com/cafeku_id" target="_blank" style="color:#ffd700; margin:0 10px; font-size:1.3rem;"><i class="fab fa-instagram"></i></a>
            <a href="https://facebook.com/cafeku.id" target="_blank" style="color:#ffd700; margin:0 10px; font-size:1.3rem;"><i class="fab fa-facebook"></i></a>
            <a href="mailto:info@cafeku.com" style="color:#ffd700; margin:0 10px; font-size:1.3rem;"><i class="fas fa-envelope"></i></a>
        </div>
    </footer>
</body>
</html> 