@extends('layouts.guest')
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
    .order-header {
        width: 100%;
        padding: 36px 0 18px 0;
        text-align: center;
        background: transparent;
    }
    .order-header-logo {
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
    .order-header-desc {
        color: #e0b873;
        font-size: 1.15rem;
        margin-top: 0.5rem;
        font-family: 'Lato', sans-serif;
        opacity: 0.92;
    }
    .order-card {
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
        padding: 2.2rem 1.3rem 1.5rem 1.3rem;
        color: #ffd700;
        font-family: 'Montserrat', 'Lato', sans-serif;
        animation: fadeIn 0.7s cubic-bezier(.4,0,.2,1);
    }
    .order-card:hover {
        box-shadow: 0 12px 48px #ffd70055;
        transform: translateY(-6px) scale(1.045);
        background: rgba(30,30,35,0.82);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: none; }
    }
    .order-card h1 {
        color: #ffd700;
        font-size: 1.18rem;
        font-weight: 700;
        margin-bottom: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
        letter-spacing: 0.5px;
    }
    .order-label {
        color: #ffd700;
        font-weight: 700;
        margin-bottom: 0.3rem;
        display: block;
        text-align: left;
        width: 100%;
        font-size: 1.05rem;
        letter-spacing: 0.2px;
    }
    .order-input {
        width: 100%;
        padding: 13px 18px;
        border-radius: 1rem;
        border: 1.5px solid #ffd70033;
        background: rgba(24,24,28,0.95);
        color: #ffd700;
        font-size: 1.08rem;
        margin-bottom: 16px;
        outline: none;
        font-family: 'Montserrat', 'Lato', sans-serif;
        transition: border 0.2s, box-shadow 0.2s;
        font-weight: 600;
    }
    .order-input:focus {
        border: 1.5px solid #ffd700;
        box-shadow: 0 2px 12px #ffd70033;
        background: rgba(30,30,35,0.98);
        color: #ffd700;
    }
    .order-btn {
        width: 100%;
        background: linear-gradient(90deg,#ffd700 0%,#b87333 100%);
        color: #18181c;
        font-weight: 700;
        border: none;
        border-radius: 0.9rem;
        padding: 12px 0;
        font-size: 1.13rem;
        margin-top: 0.5rem;
        box-shadow: 0 2px 12px #b8733340;
        transition: box-shadow 0.22s, transform 0.22s, background 0.22s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        letter-spacing: 0.5px;
    }
    .order-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .order-btn:hover {
        background: linear-gradient(90deg,#b87333 0%,#ffd700 100%);
        color: #18181c;
        box-shadow: 0 8px 32px #ffd70080;
        transform: scale(1.06);
    }
    .order-alert {
        background: rgba(30,30,35,0.98);
        color: #ffd700;
        border-radius: 8px;
        padding: 0.8rem 1rem;
        margin-bottom: 1.2rem;
        font-weight: 600;
        text-align: center;
        border: 1px solid #ffd70033;
        box-shadow: 0 1px 4px rgba(255,215,0,0.04);
    }
    .order-error {
        color: #ff6b6b;
        font-size: 0.97rem;
        margin-bottom: 0.7rem;
        margin-top: -0.7rem;
        font-weight: 500;
    }
    .order-back {
        display: inline-block;
        margin-top: 1.2rem;
        color: #ffd700;
        background: none;
        border: 1px solid #ffd70055;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
    }
    .order-back:hover {
        background: #ffd700;
        color: #181a23;
    }
    .order-footer {
        width: 100%;
        text-align: center;
        color: #ffd700;
        font-size: 1rem;
        padding: 32px 0 18px 0;
        margin-top: 32px;
        opacity: 0.7;
        font-family: 'Montserrat', sans-serif;
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
        .order-header-logo { font-size: 1.5rem; }
        .order-card { padding: 1.2rem 0.7rem 1.5rem 0.7rem; max-width: 98vw; }
        .order-card h1 { font-size: 1.1rem; }
        .order-back.modern { font-size: 1rem; padding: 10px 18px; }
    }
    @media (max-width: 600px) {
        .order-header-logo { font-size: 1.1rem; }
        .order-card { padding: 0.7rem 0.3rem 1rem 0.3rem; }
        .order-back.modern { font-size: 0.95rem; padding: 8px 10px; }
    }
</style>
<div class="order-header">
    <div class="order-header-logo">
        <i class="fas fa-coffee"></i> CafeKu
    </div>
    <div class="order-header-desc">Form pemesanan menu cafe.</div>
</div>
<div class="container py-5" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;">
    @if(session('success'))
        <div class="order-alert" style="background:linear-gradient(90deg,#ffd700 0%,#b87333 100%);color:#232526;font-size:1.1rem;font-weight:700;border:2px solid #ffd700;box-shadow:0 2px 12px #ffd70055;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(isset($menu) && $menu)
        <div class="order-card">
            @if($errors->any())
                <div class="order-alert" style="background:#ff6b6b22;color:#ffd700;font-weight:600;border:1.5px solid #ffd700;margin-bottom:0.5rem;font-family:'Montserrat',sans-serif;font-size:0.98rem;border-radius:0.9rem;padding:7px 14px;">
                    {{ $errors->first() }}
                </div>
            @endif
            <h1><i class="fas fa-receipt"></i> Pesan: {{ $menu->nama }}</h1>
            <form method="POST" action="{{ route('user.order.store') }}" onsubmit="this.querySelector('.order-btn').disabled=true;this.querySelector('.order-btn').innerHTML='<span class=\'spinner\'></span> Memproses...';">
                @csrf
                <input type="hidden" name="items[0][menu_item_id]" value="{{ $menu->id }}">
                <label class="order-label">Menu</label>
                <input type="text" class="order-input" value="{{ $menu->nama }}" readonly>
                <label class="order-label">Nomor Meja</label>
                <select name="table_id" class="order-input" required>
                    <option value="">-- Pilih Nomor Meja --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">Meja {{ $table->number }} (Kapasitas: {{ $table->kapasitas ?? '-' }})</option>
                    @endforeach
                </select>
                @error('table_id')<div class="order-error">{{ $message }}</div>@enderror
                <label class="order-label">Jumlah Pesanan</label>
                <input type="number" class="order-input" name="items[0][jumlah]" min="1" max="10" value="1" required>
                @error('items.0.jumlah')<div class="order-error">{{ $message }}</div>@enderror
                <label class="order-label">Nama Pemesan <span style="color:#aaa;font-weight:400;"></span></label>
                <input type="text" class="order-input" name="nama_pemesan" placeholder="Nama Anda (opsional)" pattern="^[a-zA-Z\s]+$" maxlength="50">
                @error('nama_pemesan')<div class="order-error">{{ $message }}</div>@enderror
                <label class="order-label">Catatan Tambahan <span style="color:#aaa;font-weight:400;"></span></label>
                <textarea class="order-input" name="catatan" maxlength="100" rows="2" placeholder="Catatan untuk pesanan (opsional)"></textarea>
                @error('catatan')<div class="order-error">{{ $message }}</div>@enderror
                <button type="submit" class="order-btn"><i class="fas fa-paper-plane"></i> Konfirmasi Pesan</button>
            </form>
            <a href="javascript:history.back()" class="order-back modern" style="margin-top:18px;"><i class="fas fa-arrow-left" style="font-size:1.25em;"></i> Kembali</a>
        </div>
    @else
        <div class="order-card" style="text-align:center;">
            <h1><i class="fas fa-info-circle"></i> Silakan pilih menu dari halaman utama untuk memesan.</h1>
            <a href="javascript:history.back()" class="order-back"><i class="fas fa-arrow-left"></i> Kembali ke Menu</a>
        </div>
    @endif
</div>
<div class="order-footer">
    &copy; {{ date('Y') }} CafeKu. All rights reserved.
</div>
<!-- Spinner style -->
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
<script>
document.querySelector('form').onsubmit = function(e) {
    if(!confirm('Yakin ingin memesan?')) {
        e.preventDefault();
        return false;
    }
};
</script>
@endsection 