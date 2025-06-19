<!-- Google Fonts CDN -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Montserrat:wght@600&family=Poppins:wght@700&display=swap" rel="stylesheet">
<x-guest-layout>
    <style>
        * {
          box-sizing: border-box;
          font-family: 'Poppins', sans-serif;
          margin: 0;
          padding: 0;
        }
        body {
          background: #f5f5f5 !important;
          font-family: 'Poppins', Arial, sans-serif;
        }
        .forgot-container {
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          background: #f5f5f5;
        }
        .forgot-card {
          display: flex;
          width: 900px;
          max-width: 98vw;
          background: #fff;
          border-radius: 1.5rem;
          box-shadow: 0 0 32px rgba(0,0,0,0.10);
          overflow: hidden;
          border: none;
        }
        .forgot-img {
          width: 50%;
          min-height: 480px;
          background-size: cover;
          background-position: center;
          background-image: url('/images/coffee-login.jpg');
        }
        .forgot-form {
          width: 50%;
          padding: 3rem 2.5rem 2.5rem 2.5rem;
          display: flex;
          flex-direction: column;
          justify-content: center;
          background: #fff;
        }
        .forgot-title {
          color: #A67C52;
          font-size: 2rem;
          font-weight: 700;
          margin-bottom: 0.5rem;
          text-align: center;
        }
        .forgot-desc {
          color: #A67C52;
          font-size: 1rem;
          margin-bottom: 2rem;
          text-align: center;
        }
        .input-group {
          margin-bottom: 1.5rem;
          position: relative;
        }
        .input-kopi {
          width: 100%;
          padding: 0.9rem 0.9rem 0.9rem 2.5rem;
          border: 1px solid #e0e0e0;
          border-radius: 0.7rem;
          background: #f9f9f9;
          color: #333;
          font-size: 1.08rem;
          transition: border 0.2s, box-shadow 0.2s;
        }
        .input-kopi:focus {
          border-color: #A67C52 !important;
          box-shadow: 0 0 0 2px #FFD70022;
          outline: none;
        }
        .input-with-icon {
          padding-left: 2.5rem !important;
        }
        .input-icon {
          position: absolute;
          left: 1rem;
          top: 50%;
          transform: translateY(-50%);
          color: #A67C52;
          pointer-events: none;
          font-size: 1.1rem;
        }
        .reg-placeholder::placeholder {
          color: #bdbdbd !important;
          opacity: 1;
        }
        .btn-kopi {
          width: 100%;
          padding: 0.9rem;
          background: #A67C52;
          color: #fff;
          font-weight: 600;
          font-size: 1.1rem;
          border: none;
          border-radius: 0.7rem;
          cursor: pointer;
          transition: background 0.2s, transform 0.2s;
          margin-top: 0.5rem;
          letter-spacing: 0.03em;
        }
        .btn-kopi:hover {
          background: #FFD700;
          color: #A67C52;
          transform: scale(1.03);
        }
        .reg-error {
          color: #FF6B6B !important;
          font-size: 0.9rem;
          margin-top: 0.25rem;
        }
        @media (max-width: 900px) {
          .forgot-card { flex-direction: column; width: 98vw; min-width: unset; }
          .forgot-img, .forgot-form { width: 100%; min-height: 180px; }
          .forgot-form { padding: 2rem 1.2rem; }
        }
        @media (max-width: 600px) {
          .forgot-card { border-radius: 0.7rem; box-shadow: 0 0 12px rgba(0,0,0,0.08); }
          .forgot-img { min-height: 120px; }
          .forgot-form { padding: 1.2rem 0.5rem; }
          .forgot-title { font-size: 1.3rem; }
          .forgot-desc { font-size: 0.95rem; }
          .input-kopi { font-size: 0.98rem; padding: 0.7rem 0.7rem 0.7rem 2.2rem; }
          .btn-kopi { font-size: 1rem; padding: 0.7rem; }
        }
    </style>
<div class="forgot-container">
  <div class="forgot-card">
    <div class="forgot-img"></div>
    <div class="forgot-form">
      <div class="mb-8" style="margin-bottom:2rem; text-align:center;">
        <img src="/images/logo.png" alt="Logo" style="width:60px;height:60px;display:block;margin:0 auto 0.5rem auto;">
        <div class="forgot-title" style="margin-bottom:0; text-align:center;">Caffee Menu App</div>
        <div class="forgot-desc" style="text-align:center;">Lupa Password</div>
      </div>
      <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" style="text-align:center; color:#A67C52; margin-bottom:1.5rem;">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
      </div>
      <x-auth-session-status class="mb-4" :status="session('status')" />
      <form method="POST" action="{{ route('password.email') }}" id="forgotForm" autocomplete="off">
        @csrf
        <div class="input-group">
          <span class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#A67C52"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-8 0v-1"/></svg></span>
          <input id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="email" class="input-kopi input-with-icon reg-placeholder">
          <x-input-error :messages="$errors->get('email')" class="reg-error" />
        </div>
        <button type="submit" class="btn-kopi">Email Password Reset Link</button>
      </form>
    </div>
  </div>
</div>
</x-guest-layout>
