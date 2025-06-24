@extends('layouts.cashier')
@section('content')
<div class="container mt-5">
    <h1>Struk Pembayaran</h1>
    <div class="border p-4 bg-white" style="max-width:400px;">
        <h4>Cafe Kamu</h4>
        <p>No. Pesanan: <b>#{{ $order->id }}</b></p>
        <p>Menu: {{ $order->menu->nama ?? '-' }}</p>
        <p>Jumlah: {{ $order->jumlah }}</p>
        <p>Total: <b>Rp{{ number_format($order->menu->harga * $order->jumlah) }}</b></p>
        <p>Status: {{ ucfirst($order->status) }}</p>
        <p>Metode: {{ ucfirst($order->metode_pembayaran) }}</p>
        <p class="mt-3">Terima kasih!</p>
    </div>
    <button class="btn btn-secondary mt-3" onclick="window.print()">Cetak</button>
</div>
@endsection 