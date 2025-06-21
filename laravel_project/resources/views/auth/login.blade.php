<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coffee Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --off-white: #faf5f0;    /* Latar belakang halaman */
            --stone-gray: #a6a6a6;   /* Teks gelap, border, tombol hover */
            --deep-brown: #362c2a;   /* Warna aksen */
            --blue-glass: #7fa7b2;   /* Warna untuk border & ikon */
            --sand: #d8c3ac;         /* Warna utama untuk teks & tombol */
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        .auth-container {
            width: 900px;
            max-width: 95vw;
            padding: 20px;
            background-color: #fff;
            border: 3px solid var(--deep-brown);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .auth-card {
            display: flex;
            background-color: #fff;
            overflow: hidden;
        }
        .auth-image-section {
            flex-basis: 55%;
            background: url("{{ asset('images/coffee-login.jpg') }}") no-repeat center center;
            background-size: cover;
        }
        .auth-form-section {
            flex-basis: 45%;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .auth-form-section h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--deep-brown);
            margin-bottom: 5px;
        }
        .auth-form-section p {
            font-size: 14px;
            color: #888;
            margin-bottom: 30px;
        }
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }
        .input-group i {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--blue-glass);
        }
        .input-group input {
            width: 100%;
            border: none;
            border-bottom: 2px solid #e0e0e0;
            padding: 10px 10px 10px 30px;
            font-size: 16px;
            background-color: transparent;
            transition: border-color 0.3s;
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--deep-brown);
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: var(--deep-brown);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .btn-submit:hover {
            background-color: var(--stone-gray);
        }
        .auth-links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .auth-links a {
            color: var(--deep-brown);
            text-decoration: none;
        }
        .auth-links a:hover {
            text-decoration: underline;
        }
        .input-group select {
            color: var(--deep-brown);
        }
        @media (max-width: 768px) {
            .auth-image-section {
                display: none;
            }
            .auth-form-section {
                flex-basis: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-image-section"></div>
            <div class="auth-form-section">
                <h1>Welcome Back, Sobat Ngopi!</h1>
                <p>Kopimu udah kangen. Yuk masuk dulu.</p>

                <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="login" placeholder="Email atau Username" value="{{ old('login') }}" required autofocus>
                    </div>
                     @error('login')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                     @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                    
                    <div class="input-group">
                        <i class="fas fa-user-tag"></i>
                        <select name="role" required style="width: 100%; border: none; border-bottom: 2px solid #e0e0e0; padding: 10px 10px 10px 30px; font-size: 16px; background-color: transparent; color: #555;">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Cashier</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="barista" {{ old('role') == 'barista' ? 'selected' : '' }}>Barista</option>
                        </select>
                    </div>
                     @error('role')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn-submit">Login</button>
                </form>

                <div class="auth-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Lupa Password?
                        </a> | 
                    @endif
                    <a href="{{ route('register') }}">Buat Akun Baru</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
