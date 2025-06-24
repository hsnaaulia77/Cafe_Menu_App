@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Checkout Pesanan</h1>
    <ul class="list-group mb-3">
        @foreach($cart as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $item->menu->nama }} (x{{ $item->jumlah }})
                <span>Rp{{ number_format($item->menu->harga * $item->jumlah) }}</span>
            </li>
        @endforeach
    </ul>
    <h4>Total: Rp{{ number_format($total) }}</h4>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="metode" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode" class="form-control">
                <option value="cash">Cash</option>
                <option value="qris">QRIS</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
    </form>
</div>
@endsection
