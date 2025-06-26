@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

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
    .full-register-wrapper {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: stretch;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .register-left, .register-right {
        flex: 1;
        min-width: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .register-left {
        background: #fff;
        z-index: 2;
        flex-direction: column;
    }
    .register-form-box {
        width: 100%;
        max-width: 400px;
        margin-top: 30px;
    }
    .register-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 2rem;
        text-align: center;
        width: 100%;
        letter-spacing: 1px;
    }
    .register-right {
        background: #0d5eb7;
    }
    @media (max-width: 991.98px) {
        .full-register-wrapper {
            flex-direction: column;
        }
        .register-right {
            display: none;
        }
        .register-left {
            min-height: 100vh;
        }
    }
</style>
@endpush

@section('body')
<div class="full-register-wrapper">
    <div class="register-left">
        <div class="register-form-box">
            <div class="register-title">Register Warkopsans</div>
            <form action="{{ route('register') }}" method="post">
                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Alamat Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <div class="mt-3 text-center" style="background: #fff8dc; padding: 10px; border-radius: 6px;">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
    <div class="register-right"></div>
</div>
@endsection