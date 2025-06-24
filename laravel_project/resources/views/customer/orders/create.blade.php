@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Pemesanan Menu</h1>
    @role('customer')
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="menu" class="form-label">Pilih Menu</label>
            <select name="menu_id" id="menu" class="form-control">
                @foreach($menus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->nama }} - Rp{{ number_format($menu->harga) }}</option>
                @endforeach
            </select>
        </div>
        <x-input-field name="jumlah" label="Jumlah" type="number" :value="old('jumlah', 1)" />
        <x-input-field name="catatan" label="Catatan Khusus" :value="old('catatan')" />
        <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
    </form>
    @endrole
</div>
@endsection
