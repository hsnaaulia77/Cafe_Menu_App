@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Menu Order</h3>
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Order
        </a>
    </div>
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" class="form-control" placeholder="Cari order..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-light border-bottom">
            <span>Daftar Order</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="py-3 px-3 text-center">#</th>
                            <th class="py-3 px-3 text-center">Meja</th>
                            <th class="py-3 px-3 text-center">No. Invoice</th>
                            <th class="py-3 px-3 text-start">Nama Customer</th>
                            <th class="py-3 px-3 text-end">Total</th>
                            <th class="py-3 px-3 text-center">Metode Pembayaran</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                            <td class="text-center">Meja {{ $order->table->nomor_meja ?? '-' }}</td>
                            <td class="text-center">INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="text-start">{{ $order->customer_name ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($order->total) }}</td>
                            <td class="text-center">{{ $order->payment_method ?? '-' }}</td>
                            <td class="text-center">
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
                            <td class="text-center">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm me-2" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus order ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
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