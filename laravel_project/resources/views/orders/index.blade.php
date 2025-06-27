@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Menu Order</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Order</span>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Tambah Order</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Meja</th>
                            <th>No. Invoice</th>
                            <th>Nama Customer</th>
                            <th>Total</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                            <td>Meja {{ $order->table->nomor_meja ?? '-' }}</td>
                            <td>INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->customer_name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->total) }}</td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                            <td>
                                @php
                                    $badge = [
                                        'menunggu' => 'warning',
                                        'diproses' => 'info',
                                        'selesai' => 'success',
                                        'dibatalkan' => 'danger',
                                    ][$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus order ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada order.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection 