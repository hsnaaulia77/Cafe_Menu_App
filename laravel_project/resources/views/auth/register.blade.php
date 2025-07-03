@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@push('css')
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
<style>
    body, html {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Montserrat', sans-serif;
        background: radial-gradient(ellipse at 70% 60%, #232526 60%, #18181c 100%) no-repeat;
        overflow-x: hidden;
        color: #fff;
    }
    .ambient-particles {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        pointer-events: none;
        z-index: 0;
    }
    .glass-card {
        background: rgba(30, 30, 35, 0.85);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37), 0 2px 8px 0 #0008;
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1.5px solid rgba(255, 215, 0, 0.15);
        padding: 2.5rem 2rem 2rem 2rem;
        max-width: 400px;
        margin: 3rem auto;
        position: relative;
        z-index: 2;
    }
    .logo-animated {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .coffee-cup {
        width: 60px; height: 60px;
        margin-bottom: 0.5rem;
        position: relative;
        animation: glow 2s infinite alternate;
    }
    @keyframes glow {
        0% { filter: drop-shadow(0 0 8px #ffd70088); }
        100% { filter: drop-shadow(0 0 24px #ffd700cc); }
    }
    .steam {
        position: absolute;
        left: 50%;
        top: 0;
        width: 8px;
        height: 30px;
        transform: translateX(-50%);
        z-index: 2;
    }
    .steam span {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(180deg, #fff8 0%, #ffd70044 100%);
        opacity: 0.7;
        animation: steamUp 2.5s infinite ease-in-out;
    }
    @keyframes steamUp {
        0% { opacity: 0.7; transform: translateY(10px) scaleX(1); }
        50% { opacity: 1; transform: translateY(-10px) scaleX(1.2); }
        100% { opacity: 0; transform: translateY(-30px) scaleX(0.8); }
    }
    .brand-title {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: #ffd700;
        text-align: center;
        margin-bottom: 0.2rem;
    }
    .brand-subtitle {
        font-size: 0.95rem;
        color: #e0b873;
        text-align: center;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
    }
    .welcome-title {
        font-size: 1.3rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 1.5rem;
        color: #fff;
    }
    .form-label {
        font-size: 0.95rem;
        color: #ffd700;
        margin-bottom: 0.3rem;
        font-weight: 500;
    }
    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border-radius: 0.8rem;
        border: 1.5px solid #ffd70033;
        background: rgba(40, 40, 45, 0.7);
        color: #fff;
        font-size: 1rem;
        margin-bottom: 1.1rem;
        outline: none;
        transition: border 0.2s;
    }
    .form-control:focus {
        border: 1.5px solid #ffd700;
        background: rgba(40, 40, 45, 0.9);
    }
    .btn-gold {
        width: 100%;
        padding: 0.9rem 0;
        border: none;
        border-radius: 0.8rem;
        background: linear-gradient(90deg, #ffd700 0%, #b87333 100%);
        color: #18181c;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 2px 12px #b8733340;
        position: relative;
        overflow: hidden;
        margin-top: 0.5rem;
        margin-bottom: 1.2rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .btn-gold:hover {
        box-shadow: 0 4px 24px #ffd70080;
        transform: translateY(-2px) scale(1.03);
    }
    .btn-gold .shimmer {
        content: '';
        position: absolute;
        top: 0; left: -75%;
        width: 50%; height: 100%;
        background: linear-gradient(120deg, transparent, #fff8 60%, transparent 100%);
        animation: shimmer 2s infinite;
    }
    @keyframes shimmer {
        0% { left: -75%; }
        100% { left: 125%; }
    }
    .register-link {
        color: #ffd700;
        text-decoration: underline;
        font-weight: 500;
        margin-left: 0.2rem;
    }
</style>
@endpush

@section('body')
<div class="ambient-particles" id="particles-js"></div>
<div class="glass-card">
    <div class="logo-animated">
        <div class="coffee-cup">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                <ellipse cx="30" cy="40" rx="18" ry="8" fill="#ffd70033"/>
                <rect x="15" y="20" width="30" height="20" rx="10" fill="#ffd700" stroke="#b87333" stroke-width="2"/>
                <rect x="20" y="10" width="20" height="10" rx="5" fill="#fff8"/>
            </svg>
            <div class="steam"><span></span></div>
        </div>
        <div class="brand-title">NOIR CAFÉ</div>
        <div class="brand-subtitle">PREMIUM COFFEE EXPERIENCE</div>
    </div>
    <div class="welcome-title">Create Your Account</div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label class="form-label" for="name">FULL NAME</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required autofocus>
        <label class="form-label" for="email">EMAIL ADDRESS</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="your@email.com" required>
        <label class="form-label" for="password">PASSWORD</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="........" required>
        <label class="form-label" for="password_confirmation">CONFIRM PASSWORD</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="........" required>
        <button type="submit" class="btn-gold"><span class="shimmer"></span>REGISTER</button>
        <div style="text-align:center; margin-bottom:1.2rem;">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="register-link">Login</a>
        </div>
    </form>
</div>
<script>
// Ambient particles effect
const canvas = document.createElement('canvas');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
canvas.style.position = 'fixed';
canvas.style.top = '0';
canvas.style.left = '0';
canvas.style.pointerEvents = 'none';
canvas.style.zIndex = '0';
document.getElementById('particles-js').appendChild(canvas);
const ctx = canvas.getContext('2d');
let particles = Array.from({length: 32}, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    r: Math.random() * 2 + 1,
    dx: (Math.random() - 0.5) * 0.2,
    dy: (Math.random() - 0.5) * 0.2,
    o: Math.random() * 0.5 + 0.2
}));
function drawParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    for (let p of particles) {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, 2 * Math.PI);
        ctx.fillStyle = `rgba(255,215,0,${p.o})`;
        ctx.shadowColor = '#ffd700';
        ctx.shadowBlur = 8;
        ctx.fill();
        p.x += p.dx;
        p.y += p.dy;
        if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
    }
    requestAnimationFrame(drawParticles);
}
drawParticles();
window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
</script>
@endsection