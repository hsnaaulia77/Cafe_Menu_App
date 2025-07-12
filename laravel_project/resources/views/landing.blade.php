<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noir Cafe - Aplikasi Pemesanan Cafe</title>
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
            box-shadow: 0 2px 12px #b8733340, 0 8px 32px #ffd70022;
            transition: box-shadow 0.2s, transform 0.2s, background 0.25s;
            margin: 12px;
            padding: 16px 40px;
            text-decoration: none;
            display: inline-block;
            z-index: 2;
        }
        .btn-main:hover {
            box-shadow: 0 4px 24px #ffd70080, 0 12px 36px #ffd70033;
            transform: translateY(-2px) scale(1.07);
            color: #18181c !important;
            background: linear-gradient(90deg, #b87333 0%, #ffd700 100%) !important;
        }
        .features {
            display: flex;
            gap: 32px;
            margin-top: 48px;
            justify-content: center;
            flex-wrap: wrap;
            background: rgba(30,30,35,0.82);
            backdrop-filter: blur(8px);
            border-radius: 1.2rem;
            box-shadow: 0 8px 32px #ffd70022;
            padding: 32px 18px 18px 18px;
            border: 1.5px solid #ffd70033;
        }
        .feature-box {
            background: rgba(30,30,35,0.92);
            color: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px #ffd70022;
            padding: 28px 20px 20px 20px;
            width: 260px;
            text-align: center;
            margin-bottom: 24px;
            border: 1.5px solid #ffd70033;
            transition: box-shadow 0.25s, transform 0.25s, background 0.25s;
            position: relative;
            z-index: 2;
        }
        .feature-box:hover {
            box-shadow: 0 8px 32px #ffd70055;
            transform: translateY(-4px) scale(1.06);
            background: linear-gradient(120deg, #232526 60%, #b87333 100%);
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
            pointer-events: none;
        }
        .hero-bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #18181c 60%, #232526 100%);
            opacity: 0.7;
            z-index: 1;
            pointer-events: none;
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
        <div class="brand-title"><i class="fas fa-coffee"></i> Noir Cafe</div>
        <div class="brand-tagline">
            Nikmati pengalaman <b>pemesanan cafe</b> yang <span style="color:#ffd700">mudah</span>, <span style="color:#ffd700">cepat</span>, dan <span style="color:#ffd700">nyaman</span>.<br>
            Pesan menu favoritmu tanpa antri, langsung dari aplikasi!
        </div>
        <div class="hero-btn-group">
            <a href="{{ route('login') }}" class="btn-main"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="{{ route('register') }}" class="btn-main" style="background:linear-gradient(90deg,#b87333 0%,#ffd700 100%) !important;"><i class="fas fa-user-plus"></i> Register</a>
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
        <a href="{{ route('user.menu') }}" class="feature-box" title="Lihat dan pesan menu favoritmu">
            <i class="fas fa-utensils"></i>
            <h3>Menu Lengkap</h3>
            <p>Lihat dan pesan berbagai menu makanan & minuman cafe favoritmu.</p>
        </a>
        @auth
        <a href="{{ route('user.order') }}" class="feature-box" title="Pesan menu tanpa antri">
            <i class="fas fa-mobile-alt"></i>
            <h3>Pemesanan Mudah</h3>
            <p>Pesan dari mana saja, kapan saja, tanpa antri di kasir.</p>
        </a>
        @else
        <a href="javascript:void(0)" class="feature-box" onclick="alert('Silakan login dulu!')" title="Login untuk memesan menu">
            <i class="fas fa-mobile-alt"></i>
            <h3>Pemesanan Mudah</h3>
            <p>Pesan dari mana saja, kapan saja, tanpa antri di kasir.</p>
        </a>
        @endauth
        <a href="{{ route('user.promo') }}" class="feature-box" title="Lihat promo terbaru">
            <i class="fas fa-gift"></i>
            <h3>Promo Menarik <span style="background:#ffec80;color:#232526;font-size:0.95rem;font-weight:700;border-radius:1rem;padding:0.18rem 0.7rem;margin-left:8px;">Baru</span></h3>
            <p>Dapatkan diskon & promo spesial setiap hari.</p>
        </a>
        <a href="javascript:void(0)" class="feature-box" id="btnReservasi" title="Reservasi meja online">
            <i class="fas fa-chair"></i>
            <h3>Reservasi Meja</h3>
            <p>Booking meja favoritmu secara online, tanpa perlu menunggu.</p>
        </a>
    </div>

    <!-- Modal Reservasi -->
    <div id="modalReservasi" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(24,24,28,0.85); align-items:center; justify-content:center;">
        <div style="background:#232526; border-radius:1.2rem; padding:32px 24px; min-width:320px; max-width:90vw; box-shadow:0 8px 32px #000a; position:relative;">
            <button onclick="closeReservasi()" style="position:absolute; top:12px; right:18px; background:none; border:none; color:#ffd700; font-size:1.5rem; cursor:pointer;">&times;</button>
            <h3 style="color:#ffd700; font-family:'Montserrat',sans-serif; margin-bottom:18px;">Reservasi Meja</h3>
            <form id="formReservasi" method="POST" action="{{ route('user.reservasi') }}">
                @csrf
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>No. Telepon</label>
                    <input type="text" name="telepon" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jam</label>
                    <input type="time" name="jam" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" class="form-control" min="1" required>
                </div>
                <div class="mb-3">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-main" style="width:100%;">Kirim Reservasi</button>
            </form>
            <div id="notifReservasi" style="display:none; margin-top:16px; color:#ffd700; text-align:center; font-weight:bold;"></div>
        </div>
    </div>
    <script>
        document.getElementById('btnReservasi').onclick = function() {
            document.getElementById('modalReservasi').style.display = 'flex';
        };
        function closeReservasi() {
            document.getElementById('modalReservasi').style.display = 'none';
        }
        document.getElementById('modalReservasi').addEventListener('click', function(e) {
            if (e.target === this) closeReservasi();
        });
    </script>
    <script>
document.getElementById('formReservasi').onsubmit = async function(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
    const notif = document.getElementById('notifReservasi');
    notif.style.display = 'none';
    notif.innerText = '';
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            body: data
        });
        if (response.ok) {
            notif.innerText = 'Reservasi berhasil dikirim!';
            notif.style.display = 'block';
            form.reset();
        } else {
            const res = await response.json();
            notif.innerText = res.message || 'Terjadi kesalahan. Coba lagi.';
            notif.style.display = 'block';
        }
    } catch (err) {
        notif.innerText = 'Gagal mengirim reservasi. Cek koneksi Anda.';
        notif.style.display = 'block';
    }
};
</script>

    <!-- SECTION GALERI & TESTIMONI -->
    <style>
        .section-container {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: flex-start;
            gap: 40px;
            margin-top: 40px;
        }
        .section {
            flex: 1;
            min-width: 300px;
        }
        .card-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 200px;
            justify-content: center;
        }
        .empty-card {
            background: rgba(40,40,40,0.7);
            border-radius: 16px;
            padding: 32px 24px;
            color: #FFD700;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
            margin-top: 16px;
            min-width: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .empty-card img {
            width: 60px;
            margin-bottom: 12px;
            opacity: 0.8;
        }
    </style>
    <div class="section-container">
        <div class="section">
            <h2 style="color:#FFD700; text-align:center;">Galeri Menu & Cafe</h2>
            <div class="card-list" style="flex-direction: row; flex-wrap: wrap; gap: 24px;">
                <div class="empty-card" style="background:rgba(30,30,35,0.92); min-width:180px; max-width:220px;">
                    <img src="{{ asset('images/croissant.jpg') }}" alt="Croissant Almond" style="border-radius:12px; width:100%; height:110px; object-fit:cover;">
                    <div style="font-weight:700; color:#FFD700; margin-top:8px;">Croissant Almond</div>
                    <div style="color:#fff; font-size:0.95rem;">Croissant renyah dengan topping almond, cocok untuk sarapan atau teman kopi.</div>
                </div>
                <div class="empty-card" style="background:rgba(30,30,35,0.92); min-width:180px; max-width:220px;">
                    <img src="{{ asset('images/matcha_latte.jpg') }}" alt="Matcha Latte" style="border-radius:12px; width:100%; height:110px; object-fit:cover;">
                    <div style="font-weight:700; color:#FFD700; margin-top:8px;">Matcha Latte</div>
                    <div style="color:#fff; font-size:0.95rem;">Minuman teh hijau creamy, segar dan sehat, dengan latte art yang cantik.</div>
                </div>
                <div class="empty-card" style="background:rgba(30,30,35,0.92); min-width:180px; max-width:220px;">
                    <img src="{{ asset('images/cappuccino.jpg') }}" alt="Cappuccino" style="border-radius:12px; width:100%; height:110px; object-fit:cover;">
                    <div style="font-weight:700; color:#FFD700; margin-top:8px;">Cappuccino</div>
                    <div style="color:#fff; font-size:0.95rem;">Kopi susu dengan foam lembut dan latte art, favorit pelanggan Noir Cafe.</div>
                </div>
            </div>
        </div>
        <div class="section">
            <h2 style="color:#FFD700; text-align:center;">Testimoni Pelanggan</h2>
            <div class="card-list" style="flex-direction: row; flex-wrap: wrap; gap: 24px;">
                <div class="empty-card" style="background:rgba(30,30,35,0.92); min-width:180px; max-width:220px;">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Andi" style="width:56px; height:56px; border-radius:50%; border:2px solid #FFD700; margin-bottom:8px;">
                    <div style="color:#fff; font-size:0.95rem; font-style:italic;">"Tempatnya cozy, kopinya enak banget!"</div>
                    <div style="color:#FFD700; font-weight:700;">Andi</div>
                    <div style="color:#FFD700;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="empty-card" style="background:rgba(30,30,35,0.92); min-width:180px; max-width:220px;">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sari" style="width:56px; height:56px; border-radius:50%; border:2px solid #FFD700; margin-bottom:8px;">
                    <div style="color:#fff; font-size:0.95rem; font-style:italic;">"Croissant-nya fresh, pelayanan ramah."</div>
                    <div style="color:#FFD700; font-weight:700;">Sari</div>
                    <div style="color:#FFD700;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <section class="fade-in" style="width:100%; max-width:800px; margin:56px auto 0 auto; padding:0 16px;">
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
    <section class="fade-in" style="width:100%; max-width:1000px; margin:56px auto 0 auto; padding:0 16px;">
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

    <!-- Particle effect canvas di hero -->
    <canvas id="heroParticles"></canvas>
    <script>
// Particle effect (bubbles gold)
const canvas = document.getElementById('heroParticles');
if(canvas) {
    const ctx = canvas.getContext('2d');
    let w = window.innerWidth, h = window.innerHeight;
    canvas.width = w; canvas.height = h;
    let particles = Array.from({length: 30}, () => ({
        x: Math.random()*w, y: Math.random()*h, r: 8+Math.random()*12, dy: 0.3+Math.random()*0.7, alpha: 0.12+Math.random()*0.18
    }));
    function draw() {
        ctx.clearRect(0,0,w,h);
        for(const p of particles) {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, 2*Math.PI);
            ctx.fillStyle = `rgba(255,215,0,${p.alpha})`;
            ctx.fill();
            p.y += p.dy;
            if(p.y-p.r > h) { p.y = -p.r; p.x = Math.random()*w; }
        }
        requestAnimationFrame(draw);
    }
    draw();
    window.addEventListener('resize', ()=>{w=window.innerWidth;h=window.innerHeight;canvas.width=w;canvas.height=h;});
}
// Scroll indicator di hero
const scrollIndicator = document.querySelector('.scroll-indicator');
if(scrollIndicator) {
    window.addEventListener('scroll', () => {
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        const scrollTop = document.documentElement.scrollTop;
        if (scrollTop + clientHeight >= scrollHeight - 100) { // Show when near bottom
            scrollIndicator.style.opacity = '1';
            scrollIndicator.style.transform = 'translateX(-50%) translateY(0)';
        } else {
            scrollIndicator.style.opacity = '0';
            scrollIndicator.style.transform = 'translateX(-50%) translateY(10px)';
        }
    });
}
// Tooltip pada fitur utama
document.querySelectorAll('.feature-box[title]').forEach(box => {
    box.addEventListener('mouseenter', function() {
        this.style.position = 'relative';
    });
    box.addEventListener('mouseleave', function() {
        this.style.position = '';
    });
});
    </script>
    <style>
        /* Particle effect, animasi icon, scroll indicator, tooltip */
        #heroParticles {
            position: absolute;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            pointer-events: none;
            z-index: 0;
        }
        .feature-box i {
            transition: transform 0.3s cubic-bezier(.4,2,.3,1);
            cursor: pointer;
        }
        .feature-box:hover i {
            transform: scale(1.18) rotate(-8deg);
        }
        .scroll-indicator {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        .scroll-indicator i {
            font-size: 2.2rem;
            color: #ffd700;
            animation: bounceDown 1.2s infinite;
        }
        @keyframes bounceDown { 0%,100%{transform:translateY(0);} 50%{transform:translateY(16px);} }
        .btn-main {
            background: linear-gradient(270deg, #ffd700 0%, #b87333 100%) !important;
            background-size: 200% 200%;
            animation: btnGradientMove 4s ease-in-out infinite alternate;
        }
        @keyframes btnGradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        /* Tooltip */
        .feature-box[title] {
            position: relative;
        }
        .feature-box[title]:hover:after {
            content: attr(title);
            position: absolute;
            left: 50%;
            bottom: 110%;
            transform: translateX(-50%);
            background: #232526ee;
            color: #ffd700;
            padding: 6px 16px;
            border-radius: 0.7rem;
            font-size: 1rem;
            white-space: nowrap;
            box-shadow: 0 2px 12px #ffd70033;
            z-index: 99;
            pointer-events: none;
        }
        @media (max-width: 900px) {
            .scroll-indicator { bottom: 12px; }
            .scroll-indicator i { font-size: 1.5rem; }
        }
    </style>
    <script>
        // Spinner loading pada AJAX reservasi
        const formReservasi = document.getElementById('formReservasi');
        if(formReservasi) {
            formReservasi.onsubmit = async function(e) {
                e.preventDefault();
                const form = e.target;
                const data = new FormData(form);
                const notif = document.getElementById('notifReservasi');
                notif.style.display = 'none';
                notif.innerText = '';
                const btn = form.querySelector('button[type="submit"]');
                const oldHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner"></span> Mengirim...';
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {'X-Requested-With': 'XMLHttpRequest'},
                        body: data
                    });
                    if (response.ok) {
                        notif.innerText = 'Reservasi berhasil dikirim!';
                        notif.style.display = 'block';
                        form.reset();
                    } else {
                        const res = await response.json();
                        notif.innerText = res.message || 'Terjadi kesalahan. Coba lagi.';
                        notif.style.display = 'block';
                    }
                } catch (err) {
                    notif.innerText = 'Gagal mengirim reservasi. Cek koneksi Anda.';
                    notif.style.display = 'block';
                }
                btn.disabled = false;
                btn.innerHTML = oldHtml;
            };
        }
    </script>
    <style>
        .spinner {
          display: inline-block;
          width: 1.1em;
          height: 1.1em;
          border: 2.5px solid #ffd700;
          border-radius: 50%;
          border-top: 2.5px solid #23263a;
          animation: spin 0.7s linear infinite;
          margin-right: 7px;
          vertical-align: middle;
        }
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
    </style>
    <style>
.reservasi-modal {
    background: rgba(30,30,35,0.92);
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px #0008;
    padding: 32px 28px 24px 28px;
    max-width: 350px;
    margin: 0 auto;
    color: #fff;
    font-family: 'Montserrat', 'Lato', sans-serif;
    position: relative;
    border: 1.5px solid #ffd70033;
}
.reservasi-modal h2, .reservasi-modal .modal-title {
    color: #FFD700;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.2rem;
    text-align: left;
}
.reservasi-modal label {
    color: #FFD700;
    font-weight: 600;
    margin-bottom: 0.3rem;
    font-size: 1rem;
}
.reservasi-modal input, .reservasi-modal textarea {
    width: 100%;
    border-radius: 0.7rem;
    border: none;
    padding: 10px 14px;
    margin-bottom: 1.1rem;
    background: rgba(255,255,255,0.12);
    color: #fff;
    font-size: 1rem;
    box-shadow: 0 2px 8px #0002;
    transition: background 0.2s, box-shadow 0.2s;
}
.reservasi-modal input:focus, .reservasi-modal textarea:focus {
    background: rgba(255,255,255,0.18);
    outline: 2px solid #FFD700;
    color: #fff;
}
.reservasi-modal textarea {
    min-height: 60px;
    resize: vertical;
}
.reservasi-modal .btn-reservasi {
    width: 100%;
    background: linear-gradient(90deg, #FFD700 0%, #b87333 100%);
    color: #232526;
    font-weight: 700;
    font-size: 1.15rem;
    border: none;
    border-radius: 0.9rem;
    padding: 14px 0;
    margin-top: 10px;
    box-shadow: 0 4px 18px #ffd70033;
    transition: box-shadow 0.2s, background 0.2s, color 0.2s;
    letter-spacing: 1px;
}
.reservasi-modal .btn-reservasi:hover {
    background: linear-gradient(90deg, #b87333 0%, #FFD700 100%);
    color: #18181c;
    box-shadow: 0 8px 32px #ffd70055;
}
@media (max-width: 500px) {
    .reservasi-modal {
        padding: 18px 6vw 18px 6vw;
        max-width: 98vw;
    }
}
</style>

<!-- Contoh form reservasi meja -->
<div class="reservasi-modal">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem;">
        <span class="modal-title">Reservasi Meja</span>
        <button type="button" style="background:none; border:none; color:#FFD700; font-size:1.3rem; font-weight:bold; cursor:pointer;">&times;</button>
    </div>
    <form>
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" placeholder="Nama Anda" required>
        <label for="telepon">No. Telepon</label>
        <input type="text" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required>
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" required>
        <label for="jam">Jam</label>
        <input type="time" id="jam" name="jam" required>
        <label for="jumlah">Jumlah Orang</label>
        <input type="number" id="jumlah" name="jumlah" min="1" placeholder="Jumlah orang" required>
        <label for="catatan">Catatan</label>
        <textarea id="catatan" name="catatan" placeholder="Catatan tambahan (opsional)"></textarea>
        <button type="submit" class="btn-reservasi">Kirim Reservasi</button>
    </form>
</div>
</body>
</html> 