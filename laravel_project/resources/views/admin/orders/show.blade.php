@extends('layouts.app')

@section('title', 'Detail Order #' . $order->id)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Order #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Order</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 text-right">
                    <a href="{{ route('admin.orders.print', $order) }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-print"></i> Cetak Struk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Order Details -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Order</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>ID Order:</strong></td>
                                            <td>#{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Customer:</strong></td>
                                            <td>{{ $order->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Telepon:</strong></td>
                                            <td>{{ $order->customer_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td>{{ $order->customer_address ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Order:</strong></td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge {{ $order->status_badge }} badge-lg">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Metode Bayar:</strong></td>
                                            <td>{{ $order->payment_method_label }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total:</strong></td>
                                            <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibayar:</strong></td>
                                            <td>
                                                @if($order->paid_amount)
                                                    <span class="text-success">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-warning">Belum dibayar</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kembalian:</strong></td>
                                            <td>
                                                @if($order->paid_amount && $order->paid_amount > $order->total_amount)
                                                    <span class="text-info">Rp {{ number_format($order->paid_amount - $order->total_amount, 0, ',', '.') }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($order->notes)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Catatan Customer:</h6>
                                    <p class="text-muted">{{ $order->notes }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->admin_notes)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Catatan Admin:</h6>
                                    <p class="text-muted">{{ $order->admin_notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Item Order</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $item->menu->name }}</strong>
                                                @if($item->notes)
                                                    <br><small class="text-muted">{{ $item->notes }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td><strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">
                                            <p class="text-muted mb-0">Tidak ada item order</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total:</th>
                                        <th>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Status Management -->
                <div class="col-md-4">
                    <!-- Status Update -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Status</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="status">Status Order</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                        <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Siap</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="admin_notes">Catatan Admin</label>
                                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                              placeholder="Catatan untuk order ini...">{{ $order->admin_notes }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Payment -->
                    @if($order->status != 'cancelled')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.orders.mark-paid', $order) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="paid_amount">Jumlah Dibayar</label>
                                    <input type="number" class="form-control" id="paid_amount" name="paid_amount" 
                                           value="{{ $order->paid_amount }}" step="100" min="0" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-money-bill"></i> Catat Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Aksi Cepat</h3>
                        </div>
                        <div class="card-body">
                            <div class="btn-group-vertical w-100">
                                @if($order->canBeProcessed())
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-cog"></i> Mulai Proses
                                    </button>
                                </form>
                                @endif

                                @if($order->status == 'processing')
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Siap Diambil
                                    </button>
                                </form>
                                @endif

                                @if($order->status == 'ready')
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-flag-checkered"></i> Selesai
                                    </button>
                                </form>
                                @endif

                                @if(!$order->isCompleted() && $order->status != 'cancelled')
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin membatalkan order ini?')">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-times"></i> Batalkan Order
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection 