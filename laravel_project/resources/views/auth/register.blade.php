<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Coffee Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --off-white: #faf5f0;
            --stone-gray: #a6a6a6;
            --deep-brown: #362c2a;
            --blue-glass: #7fa7b2;
            --sand: #d8c3ac;
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
        .input-group input, .input-group select {
            width: 100%;
            border: none;
            border-bottom: 2px solid #e0e0e0;
            padding: 10px 10px 10px 30px;
            font-size: 16px;
            background-color: transparent;
            transition: border-color 0.3s;
        }
        .input-group input:focus, .input-group select:focus {
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
        .text-danger {
            color: #e3342f;
            font-size: 12px;
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
                <h1>Daftar Kilat, Ngopi Nikmat!</h1>
                <p>Gabung sekarang, dan rasain vibes-nya.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                    </div>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required>
                    </div>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>

                    <div class="input-group">
                        <i class="fas fa-user-tag"></i>
                        <select name="role" required style="color: #555;">
                            <option value="" disabled selected>Pilih Role Anda</option>
                            <option value="customer">Customer</option>
                            <option value="kasir">Cashier</option>
                            <option value="admin">Admin</option>
                            <option value="barista">Barista</option>
                        </select>
                    </div>
                     @error('role') <span class="text-danger">{{ $message }}</span> @enderror

                    <button type="submit" class="btn-submit">Daftar Sekarang</button>
                </form>

                <div class="auth-links">
                    <a href="{{ route('login') }}">Sudah punya akun? Login di sini</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
