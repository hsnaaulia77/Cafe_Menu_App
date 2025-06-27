@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Profil Saya</h3>
    @include('profile.partials.update-profile-information-form')
    <hr>
    @include('profile.partials.update-password-form')
    <hr>
    @include('profile.partials.delete-user-form')
</div>
@endsection
