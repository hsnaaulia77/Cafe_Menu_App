@extends('layouts.cashier')
@section('content')
<div class="container mt-5">
    <h1>Riwayat Transaksi</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->menu->nama ?? '-' }}</td>
                <td>{{ $order->jumlah }}</td>
                <td>Rp{{ number_format($order->menu->harga * $order->jumlah) }}</td>
                <td>{{ $order->updated_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 