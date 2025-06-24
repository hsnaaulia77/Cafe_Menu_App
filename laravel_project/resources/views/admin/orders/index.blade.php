@extends('layouts.app')

@section('title', 'Manajemen Order')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Order</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Manajemen Order</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card">
            <div class="card-header card-header-coffee">
                <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter Order</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.index') }}">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="ID, Nama, atau No. HP">
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Siap</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control" name="payment_method">
                                <option value="">Semua Metode Bayar</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Kartu</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" title="Dari Tanggal">
                        </div>
                        <div class="col-md-2 form-group">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <form id="bulk-action-form" method="POST" action="{{ route('admin.orders.bulk-action') }}">
            @csrf
            <div class="row mb-2">
                <div class="col-md-3">
                    <select name="bulk_action" class="form-control" id="bulk-action-select" required>
                        <option value="">Pilih Aksi Massal</option>
                        <option value="update_status">Ubah Status</option>
                        <option value="delete">Hapus</option>
                    </select>
                </div>
                <div class="col-md-3" id="bulk-status-select" style="display:none;">
                    <select name="status" class="form-control">
                        <option value="">Pilih Status Baru</option>
                        <option value="pending">Menunggu</option>
                        <option value="confirmed">Dikonfirmasi</option>
                        <option value="processing">Diproses</option>
                        <option value="ready">Siap</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Terapkan ke Terpilih</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Order</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.orders.export.excel', request()->query()) }}">
                                    <i class="fas fa-file-excel text-success mr-1"></i> Excel (.xls)
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.orders.export.csv', request()->query()) }}">
                                    <i class="fas fa-file-csv text-info mr-1"></i> CSV
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.orders.export.pdf', request()->query()) }}">
                                    <i class="fas fa-file-pdf text-danger mr-1"></i> PDF
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-plus"></i> Tambah Order
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="bg-light">
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Metode Bayar</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}"></td>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>
                                    <div>
                                        <strong>{{ $order->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $order->customer_phone }}</small>
                                    </div>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    @if($order->paid_amount)
                                        <br><small class="text-success">Dibayar: Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $order->status_badge }} px-2 py-1" style="font-size: 0.8rem;">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>{{ $order->payment_method_label }}</td>
                                <td>
                                    <small>{{ $order->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!$order->isCompleted())
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5>Tidak Ada Order Ditemukan</h5>
                                    <p class="text-muted">Coba ubah filter Anda atau buat order baru.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($orders->hasPages())
                <div class="card-footer clearfix">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </form>
    </div>
</section>
<script>
    document.getElementById('select-all').onclick = function() {
        let checkboxes = document.querySelectorAll('input[name="order_ids[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
    document.getElementById('bulk-action-select').onchange = function() {
        document.getElementById('bulk-status-select').style.display = (this.value === 'update_status') ? '' : 'none';
    };
</script>
@endsection 