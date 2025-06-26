@extends('adminlte::auth.auth-page', ['auth_type' => 'forgot'])

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
    .full-forgot-wrapper {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: stretch;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .forgot-left, .forgot-right {
        flex: 1;
        min-width: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .forgot-left {
        background: #fff;
        z-index: 2;
        flex-direction: column;
    }
    .forgot-form-box {
        width: 100%;
        max-width: 400px;
        margin-top: 30px;
    }
    .forgot-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 2rem;
        text-align: center;
        width: 100%;
        letter-spacing: 1px;
    }
    .forgot-right {
        background: #0d5eb7;
    }
    @media (max-width: 991.98px) {
        .full-forgot-wrapper {
            flex-direction: column;
        }
        .forgot-right {
            display: none;
        }
        .forgot-left {
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
<div class="full-forgot-wrapper">
    <div class="forgot-left">
        <div class="forgot-title">Lupa Password</div>
        <div class="forgot-form-box">
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset Password</button>
            </form>
            <div class="mt-3 text-center" style="background: #fff8dc; padding: 10px; border-radius: 6px;">
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>
    <div class="forgot-right"></div>
        </div>
@endsection
