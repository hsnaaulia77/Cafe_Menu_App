@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Profil Saya</h1>
    @role('customer')
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <x-input-field name="name" label="Nama" :value="old('name', $user->name)" />
            <x-input-field name="email" label="Email" type="email" :value="old('email', $user->email)" />
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (opsional)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    @endrole
</div>
@endsection 