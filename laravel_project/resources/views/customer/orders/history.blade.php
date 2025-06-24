@extends('layouts.customer')
@section('content')
<div class="container mt-5">
    <h1>Riwayat Pesanan</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Menu</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    <ul>
                        @foreach($order->items as $item)
                            <li>{{ $item->menu->nama }} (x{{ $item->jumlah }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>Rp{{ number_format($order->total) }}</td>
                <td>
                    <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'diproses' ? 'warning' : 'danger') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
