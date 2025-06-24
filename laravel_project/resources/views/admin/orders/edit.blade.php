@extends('layouts.app')

@section('title', 'Edit Order #' . $order->id)

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Order #{{ $order->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Manajemen Order</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.show', $order) }}">Detail</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-coffee">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                Form Edit Order
                            </h3>
                        </div>
                        <div class="card-body">
                            {{-- Customer Information --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_name">Nama Customer <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" name="customer_name" 
                                               value="{{ old('customer_name', $order->customer_name) }}" required>
                                        @error('customer_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_phone">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                               id="customer_phone" name="customer_phone" 
                                               value="{{ old('customer_phone', $order->customer_phone) }}" required>
                                        @error('customer_phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="customer_address">Alamat</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                          id="customer_address" name="customer_address" rows="2">{{ old('customer_address', $order->customer_address) }}</textarea>
                                @error('customer_address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Payment Information --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_amount">Total Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control @error('total_amount') is-invalid @enderror" 
                                                   id="total_amount" name="total_amount" 
                                                   value="{{ old('total_amount', $order->total_amount) }}" 
                                                   min="0" step="100" required>
                                        </div>
                                        @error('total_amount')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="paid_amount">Jumlah Dibayar</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" 
                                                   id="paid_amount" name="paid_amount" 
                                                   value="{{ old('paid_amount', $order->paid_amount) }}" 
                                                   min="0" step="100">
                                        </div>
                                        @error('paid_amount')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_method">Metode Pembayaran <span class="text-danger">*</span></label>
                                        <select class="form-control @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" name="payment_method" required>
                                            <option value="">Pilih metode pembayaran</option>
                                            <option value="cash" {{ old('payment_method', $order->payment_method) == 'cash' ? 'selected' : '' }}>Tunai</option>
                                            <option value="transfer" {{ old('payment_method', $order->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                            <option value="qris" {{ old('payment_method', $order->payment_method) == 'qris' ? 'selected' : '' }}>QRIS</option>
                                            <option value="card" {{ old('payment_method', $order->payment_method) == 'card' ? 'selected' : '' }}>Kartu</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="notes">Catatan Customer</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="3" 
                                                  placeholder="Catatan dari customer...">{{ old('notes', $order->notes) }}</textarea>
                                        @error('notes')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admin_notes">Catatan Admin</label>
                                        <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                                  id="admin_notes" name="admin_notes" rows="3" 
                                                  placeholder="Catatan internal admin...">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                                        @error('admin_notes')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-coffee">
                        <h3 class="card-title">
                            <i class="fas fa-tag mr-1"></i>
                            Status Order
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <span class="badge {{ $order->status_badge }} px-3 py-2" style="font-size: 1rem;">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div class="small text-muted">
                            <p class="mb-1"><strong>Dibuat:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            @if($order->processed_at)
                                <p class="mb-1"><strong>Diproses:</strong> {{ $order->processed_at->format('d/m/Y H:i') }}</p>
                            @endif
                            @if($order->completed_at)
                                <p class="mb-1"><strong>Selesai:</strong> {{ $order->completed_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header card-header-coffee">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Informasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-light mb-0">
                            <h6 class="text-brown"><i class="fas fa-exclamation-triangle"></i> Perhatian:</h6>
                            <ul class="mb-0 pl-3">
                                <li>Perubahan total amount akan mempengaruhi perhitungan.</li>
                                <li>Status order dapat diubah melalui halaman detail.</li>
                                <li>Catatan admin hanya terlihat oleh admin.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 