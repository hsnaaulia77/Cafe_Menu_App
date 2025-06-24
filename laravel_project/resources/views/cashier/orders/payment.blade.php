@extends('layouts.cashier')
@section('content')
<div class="container mt-5">
    <h1>Pembayaran Pesanan #{{ $order->id }}</h1>
    <form action="{{ route('cashier.orders.pay', $order->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="metode" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode" class="form-control">
                <option value="tunai">Tunai</option>
                <option value="qris">QRIS</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
    </form>
</div>
@endsection 