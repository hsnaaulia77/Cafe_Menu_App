@extends('layouts.app')

@section('content')
<style>
    body { background: #181a23; }
    .order-table-card {
        background: rgba(30,32,40,0.98);
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
        color: #ffd700;
        margin-bottom: 2rem;
    }
    .order-table-card .card-header {
        background: #23263a;
        color: #ffd700;
        font-weight: 700;
        border-radius: 18px 18px 0 0;
        font-size: 1.2rem;
        letter-spacing: 1px;
    }
    .order-table-card .table {
        color: #ffd700;
        background: transparent;
    }
    .order-table-card .table-striped > tbody > tr:nth-of-type(odd) {
        background: rgba(24,24,28,0.85);
    }
    .order-table-card .table-striped > tbody > tr:hover {
        background: #23263a;
        color: #fff;
    }
    .order-table-card .badge {
        font-size: 0.95em;
        padding: 0.5em 0.9em;
        border-radius: 1em;
        font-weight: 600;
    }
    .badge-warning { background: #ffb300; color: #181a23; }
    .badge-info { background: #00bcd4; color: #fff; }
    .badge-success { background: #43a047; color: #fff; }
    .badge-danger { background: #e53935; color: #fff; }
    .badge-secondary { background: #757575; color: #fff; }
    .order-action-btns .btn { margin-right: 0.3em; }
    .order-action-btns .btn { border-radius: 0.7em; font-size: 1.05em; }
    .order-action-btns .btn-info { background: #23263a; color: #ffd700; border: none; }
    .order-action-btns .btn-warning { background: #ffb300; color: #181a23; border: none; }
    .order-action-btns .btn-danger { background: #e53935; color: #fff; border: none; }
    .order-action-btns .btn-info:hover, .order-action-btns .btn-warning:hover, .order-action-btns .btn-danger:hover { opacity: 0.85; }
    @media (max-width: 600px) {
        .order-table-card .table th, .order-table-card .table td { font-size: 0.92em; padding: 0.5em 0.3em; }
        .order-action-btns .btn { font-size: 0.95em; padding: 0.3em 0.5em; }
    }
</style>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color:#ffd700;"><i class="fas fa-receipt"></i> Menu Order</h3>
        <a href="{{ route('orders.create') }}" class="btn btn-cafe btn-sm">
            <i class="fas fa-plus"></i> Tambah Order
        </a>
    </div>
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" class="form-control bg-dark text-gold border-0" placeholder="Cari order..." value="{{ request('search') }}">
            <button class="btn btn-outline-gold" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success order-alert">{{ session('success') }}</div>
    @endif
    <div class="card order-table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Order</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
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
                                        'menunggu' => 'badge-warning',
                                        'diproses' => 'badge-info',
                                        'selesai' => 'badge-success',
                                        'dibatalkan' => 'badge-danger',
                                    ][$order->status] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="text-center order-action-btns">
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