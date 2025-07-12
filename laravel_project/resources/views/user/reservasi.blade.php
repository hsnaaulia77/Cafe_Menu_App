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
    .reservasi-header {
        width: 100%;
        padding: 36px 0 18px 0;
        text-align: center;
        background: transparent;
    }
    .reservasi-header-logo {
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
    .reservasi-header-desc {
        color: #e0b873;
        font-size: 1.15rem;
        margin-top: 0.5rem;
        font-family: 'Lato', sans-serif;
        opacity: 0.92;
    }
    .reservasi-card {
        background: rgba(30,30,35,0.75);
        border-radius: 1.3rem;
        box-shadow: 0 6px 32px #0007;
        border: 1.5px solid #ffd70033;
        width: 100%;
        max-width: 400px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 auto 36px auto;
        position: relative;
        transition: box-shadow 0.25s, transform 0.25s, background 0.25s;
        backdrop-filter: blur(6px);
        padding: 2.2rem 1.3rem 1.5rem 1.3rem;
        color: #ffd700;
        font-family: 'Montserrat', 'Lato', sans-serif;
    }
    .reservasi-card h1 {
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
    .reservasi-label {
        color: #ffd700;
        font-weight: 700;
        margin-bottom: 0.3rem;
        display: block;
        text-align: left;
        width: 100%;
        font-size: 1.05rem;
        letter-spacing: 0.2px;
    }
    .reservasi-input, .reservasi-select, .reservasi-textarea {
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
    .reservasi-input:focus, .reservasi-select:focus, .reservasi-textarea:focus {
        border: 1.5px solid #ffd700;
        box-shadow: 0 2px 12px #ffd70033;
        background: rgba(30,30,35,0.98);
        color: #ffd700;
    }
    .reservasi-btn {
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
    .reservasi-btn:hover {
        background: linear-gradient(90deg,#b87333 0%,#ffd700 100%);
        color: #18181c;
        box-shadow: 0 8px 32px #ffd70080;
        transform: scale(1.06);
    }
    .reservasi-footer {
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
        .reservasi-header-logo { font-size: 1.5rem; }
        .reservasi-card { padding: 1.2rem 0.7rem 1.5rem 0.7rem; max-width: 98vw; }
        .reservasi-card h1 { font-size: 1.1rem; }
        .order-back.modern { font-size: 1rem; padding: 10px 18px; }
    }
    @media (max-width: 600px) {
        .reservasi-header-logo { font-size: 1.1rem; }
        .reservasi-card { padding: 0.7rem 0.3rem 1rem 0.3rem; }
        .order-back.modern { font-size: 0.95rem; padding: 8px 10px; }
    }
    .input-group-icon {
        position: relative;
        width: 100%;
        margin-bottom: 18px;
    }
    .input-group-icon i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #ffd700;
        font-size: 1.1rem;
        opacity: 0.85;
        pointer-events: none;
        z-index: 2;
    }
    .reservasi-input, .reservasi-select, .reservasi-textarea {
        padding-left: 44px !important;
    }
    .floating-label {
        position: absolute;
        left: 44px;
        top: 50%;
        transform: translateY(-50%);
        color: #ffd700cc;
        font-size: 1rem;
        pointer-events: none;
        transition: 0.18s cubic-bezier(.4,2,.3,1);
        background: transparent;
        z-index: 3;
    }
    .input-group-icon input:focus + .floating-label,
    .input-group-icon input:not(:placeholder-shown) + .floating-label,
    .input-group-icon select:focus + .floating-label,
    .input-group-icon select:not([value=""]) + .floating-label,
    .input-group-icon textarea:focus + .floating-label,
    .input-group-icon textarea:not(:placeholder-shown) + .floating-label {
        top: -12px;
        left: 38px;
        font-size: 0.88rem;
        color: #ffd700;
        background: #232526;
        padding: 0 6px;
        border-radius: 0.5em;
    }
    .reservasi-btn[disabled] {
        opacity: 0.7;
        pointer-events: none;
    }
    .spinner {
        border: 3px solid #ffd70033;
        border-top: 3px solid #ffd700;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        animation: spin 0.7s linear infinite;
        display: inline-block;
        vertical-align: middle;
        margin-right: 8px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    :root {
        --gold: #FFD700;
        --gold-bright: #ffe066;
        --error: #ff6b6b;
    }
    .input-group-icon {
        position: relative;
        width: 100%;
        margin-bottom: 22px;
    }
    .input-group-icon i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gold);
        font-size: 1.1rem;
        opacity: 0.85;
        pointer-events: none;
        z-index: 2;
        transition: color 0.2s;
    }
    .reservasi-input, .reservasi-select, .reservasi-textarea {
        padding-left: 44px !important;
        transition: border 0.22s, box-shadow 0.22s, background 0.22s;
    }
    .floating-label {
        position: absolute;
        left: 44px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gold);
        font-size: 1rem;
        pointer-events: none;
        transition: 0.18s cubic-bezier(.4,2,.3,1), color 0.22s;
        background: transparent;
        z-index: 3;
    }
    .input-group-icon input:focus + .floating-label,
    .input-group-icon input:not(:placeholder-shown) + .floating-label,
    .input-group-icon select:focus + .floating-label,
    .input-group-icon select:not([value=""]) + .floating-label,
    .input-group-icon textarea:focus + .floating-label,
    .input-group-icon textarea:not(:placeholder-shown) + .floating-label {
        top: -12px;
        left: 38px;
        font-size: 0.88rem;
        color: var(--gold-bright);
        background: #232526;
        padding: 0 6px;
        border-radius: 0.5em;
    }
    .reservasi-btn {
        width: 100%;
        background: linear-gradient(90deg, var(--gold) 0%, #b87333 100%);
        color: #18181c;
        font-weight: 800;
        border: none;
        border-radius: 1.2rem;
        padding: 20px 0;
        font-size: 1.25rem;
        margin-top: 18px;
        box-shadow: 0 4px 18px #ffd70033;
        transition: box-shadow 0.22s, background 0.22s, color 0.22s, font-size 0.22s, padding 0.22s;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .reservasi-btn[disabled] {
        opacity: 0.7;
        pointer-events: none;
    }
    .reservasi-btn:hover {
        background: linear-gradient(90deg, #b87333 0%, var(--gold) 100%);
        color: #18181c;
        box-shadow: 0 8px 32px #ffd70080;
        font-size: 1.28rem;
        padding: 22px 0;
    }
    @media (max-width: 600px) {
        .reservasi-btn { font-size: 1.08rem; padding: 16px 0; border-radius: 1rem; }
    }
    .input-error {
        border: 1.5px solid var(--error) !important;
        animation: shake 0.22s linear 1;
        background: rgba(255,107,107,0.08) !important;
    }
    .label-error {
        color: var(--error) !important;
    }
    .icon-error {
        color: var(--error) !important;
    }
    @keyframes shake {
        0% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
        100% { transform: translateX(0); }
    }
</style>
<div class="reservasi-header">
    <div class="reservasi-header-logo">
        <i class="fas fa-chair"></i> Reservasi Meja
    </div>
    <div class="reservasi-header-desc">Pesan meja favorit Anda di CafeKu.</div>
</div>
@php
    $tables = \App\Models\Table::where('status','tersedia')->orderBy('number')->get();
@endphp
<div class="reservasi-card">
    <h1><i class="fas fa-calendar-check"></i> Form Reservasi</h1>
    <form method="POST" action="{{ url('/reservasi') }}" id="formReservasi" autocomplete="off">
        @csrf
        <div class="input-group-icon">
            <i class="fas fa-chair"></i>
            <select name="table_id" class="reservasi-select" required>
                <option value="">-- Pilih Meja --</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">Meja {{ $table->number }} (Kapasitas: {{ $table->kapasitas }})</option>
                @endforeach
            </select>
            <span class="floating-label">Nomor Meja</span>
        </div>
        <div class="input-group-icon">
            <i class="fas fa-user"></i>
            <input type="text" name="nama_pemesan" class="reservasi-input" placeholder=" " required>
            <span class="floating-label">Nama Pemesan</span>
        </div>
        <div class="input-group-icon">
            <i class="fas fa-users"></i>
            <input type="number" name="jumlah_orang" class="reservasi-input" min="1" max="20" value="1" placeholder=" " required>
            <span class="floating-label">Jumlah Orang</span>
        </div>
        <div class="input-group-icon">
            <i class="fas fa-calendar-alt"></i>
            <input type="date" name="tanggal" class="reservasi-input" placeholder=" " required>
            <span class="floating-label">Tanggal</span>
        </div>
        <div class="input-group-icon">
            <i class="fas fa-clock"></i>
            <input type="time" name="jam" class="reservasi-input" placeholder=" " required>
            <span class="floating-label">Jam</span>
        </div>
        <div class="input-group-icon">
            <i class="fas fa-sticky-note"></i>
            <textarea name="catatan" class="reservasi-textarea" rows="2" placeholder=" "></textarea>
            <span class="floating-label">Catatan (opsional)</span>
        </div>
        <button type="submit" class="reservasi-btn" id="btnReservasi"><i class="fas fa-paper-plane"></i> <span id="btnText">Konfirmasi Reservasi</span></button>
    </form>
    <a href="javascript:history.back()" class="order-back modern"><i class="fas fa-arrow-left" style="font-size:1.25em;"></i> Kembali</a>
</div>
<script>
    document.getElementById('formReservasi').addEventListener('submit', function(e) {
        var form = this;
        var btn = document.getElementById('btnReservasi');
        var btnText = document.getElementById('btnText');
        var valid = true;
        // Reset error
        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
        form.querySelectorAll('.label-error').forEach(el => el.classList.remove('label-error'));
        form.querySelectorAll('.icon-error').forEach(el => el.classList.remove('icon-error'));
        // Validasi manual required
        form.querySelectorAll('.reservasi-input, .reservasi-select').forEach(function(input) {
            var group = input.closest('.input-group-icon');
            var label = group.querySelector('.floating-label');
            var icon = group.querySelector('i');
            if(input.hasAttribute('required') && !input.value) {
                input.classList.add('input-error');
                label.classList.add('label-error');
                icon.classList.add('icon-error');
                valid = false;
            }
        });
        if(!valid) {
            e.preventDefault();
            return false;
        }
        btn.disabled = true;
        btnText.innerHTML = '<span class="spinner"></span>Memproses...';
    });
</script>
<div class="reservasi-footer">
    &copy; {{ date('Y') }} CafeKu. All rights reserved.
</div>
@endsection 