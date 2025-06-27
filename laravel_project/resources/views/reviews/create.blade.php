@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Review Baru</h1>
    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_customer" class="form-label">Nama Customer (Opsional/Anonim)</label>
            <input type="text" name="nama_customer" id="nama_customer" class="form-control" value="{{ old('nama_customer') }}">
        </div>
        <div class="mb-3">
            <label for="menu_item_id" class="form-label">Menu yang Direview</label>
            <select name="menu_item_id" id="menu_item_id" class="form-control" required>
                <option value="">-- Pilih Menu --</option>
                @foreach($menuItems as $item)
                    <option value="{{ $item->id }}" {{ old('menu_item_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">-- Pilih Rating --</option>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                @endfor
            </select>
        </div>
        <div class="mb-3">
            <label for="komentar" class="form-label">Komentar</label>
            <textarea name="komentar" id="komentar" class="form-control" rows="3" required>{{ old('komentar') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection 