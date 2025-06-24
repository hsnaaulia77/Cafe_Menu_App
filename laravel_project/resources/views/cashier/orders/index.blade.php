@extends('layouts.cashier')
@section('content')
<div class="container mt-5">
    <h1>Daftar Pesanan Baru</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->menu->nama ?? '-' }}</td>
                <td>{{ $order->jumlah }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    <a href="{{ route('cashier.orders.payment', $order->id) }}" class="btn btn-success btn-sm">Proses Pembayaran</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 