@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@push('css')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: #dbeff2 !important;
        width: 100vw;
        overflow-x: hidden;
    }
    .full-login-wrapper {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: stretch;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .login-left, .login-right {
        flex: 1;
        min-width: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-left {
        background: #fff;
        z-index: 2;
        flex-direction: column;
    }
    .login-form-box {
        width: 100%;
        max-width: 400px;
        margin-top: 30px;
    }
    .login-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 2rem;
        text-align: center;
        width: 100%;
        letter-spacing: 1px;
    }
    .login-right {
        background: #0d5eb7; /* warna biru lebih solid */
    }
    @media (max-width: 991.98px) {
        .full-login-wrapper {
            flex-direction: column;
        }
        .login-right {
            display: none;
        }
        .login-left {
            min-height: 100vh;
        }
    }
</style>
@endpush

@section('body')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if ($errors->has('email'))
    <div class="alert alert-danger">
        {{ $errors->first('email') }}
    </div>
@endif
<div class="full-login-wrapper">
    <div class="login-left">
        <div class="login-title">Login Warkopsans</div>
        <div class="login-form-box">
            <form action="{{ route('login') }}" method="post">
        @csrf

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
        </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
        </div>
        </div>

                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </form>

            <div class="mt-3 text-center" style="background: #fff8dc; padding: 10px; border-radius: 6px;">
                <a href="{{ route('password.request') }}">Lupa kata sandi Anda?</a>
                <br>
                <span>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang.</a></span>
            </div>
        </div>
    </div>
    <div class="login-right"></div>
</div>
@endsection
