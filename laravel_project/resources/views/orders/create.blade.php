@extends('layouts.app')

@section('title', 'Form Pemesanan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Form Pemesanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Pemesanan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-receipt"></i> Form Pemesanan Menu
                        </h3>
                    </div>
                    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                        @csrf
                        <div class="card-body">
                            <!-- Identitas Pelanggan -->
                            <div class="form-section mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Identitas Pelanggan
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_name">Nama Lengkap <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="customer_name" name="customer_name" required placeholder="Contoh: John Doe">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_phone">Nomor HP/WA <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required placeholder="08xxxxxxxxxx">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_email">Email (Opsional)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" class="form-control" id="customer_email" name="customer_email" placeholder="Contoh: nama@email.com">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Pesanan -->
                            <div class="form-section mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-shopping-cart"></i> Detail Pesanan
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="menu_item">Menu <span class="text-danger">*</span></label>
                                            <select class="form-control" id="menu_item" name="menu_item_id" required onchange="updatePrice()">
                                                <option value="">-- Pilih Menu --</option>
                                                @foreach($menus as $menu)
                                                    <option value="{{ $menu->id }}" data-price="{{ $menu->harga }}" data-name="{{ $menu->nama }}">
                                                        {{ $menu->nama }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Jumlah <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required onchange="updateTotal()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipe Order & Pembayaran -->
                            <div class="form-section mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-credit-card"></i> Tipe & Pembayaran
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_type">Tipe Order <span class="text-danger">*</span></label>
                                            <select name="order_type" id="order_type" class="form-control" required onchange="toggleOrderFields()">
                                                <option value="">Pilih Tipe Order</option>
                                                <option value="dine-in">Dine-in</option>
                                                <option value="takeaway">Takeaway</option>
                                                <option value="delivery">Delivery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_method">Metode Pembayaran <span class="text-danger">*</span></label>
                                            <select name="payment_method" id="payment_method" class="form-control" required>
                                                <option value="">Pilih Metode Pembayaran</option>
                                                <option value="cash">Tunai</option>
                                                <option value="transfer">Transfer Bank</option>
                                                <option value="qris">QRIS</option>
                                                <option value="ewallet">E-Wallet</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fields untuk Delivery -->
                                <div id="delivery-fields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="delivery_address">Alamat Pengiriman <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" placeholder="Masukkan alamat lengkap untuk pengiriman"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fields untuk Dine-in -->
                                <div id="dinein-fields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="table_number">Nomor Meja <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="table_number" name="table_number" placeholder="Contoh: A1, B2, dll">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reservation_time">Waktu Reservasi</label>
                                                <input type="datetime-local" class="form-control" id="reservation_time" name="reservation_time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ringkasan Pesanan -->
                            <div class="form-section">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-list"></i> Ringkasan Pesanan
                                </h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Menu:</strong> <span id="selected-menu">-</span></p>
                                                <p><strong>Jumlah:</strong> <span id="selected-quantity">-</span></p>
                                                <p><strong>Harga Satuan:</strong> <span id="unit-price">-</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Subtotal:</strong> <span id="subtotal">Rp 0</span></p>
                                                <p><strong>Biaya Pengiriman:</strong> <span id="delivery-fee">Rp 0</span></p>
                                                <hr>
                                                <h5><strong>Total:</strong> <span id="total-amount" class="text-primary">Rp 0</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Menu
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim Pesanan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let selectedPrice = 0;
let deliveryFee = 5000; // Biaya pengiriman default

function updatePrice() {
    const menuSelect = document.getElementById('menu_item');
    const selectedOption = menuSelect.options[menuSelect.selectedIndex];
    
    if (selectedOption.value) {
        selectedPrice = parseInt(selectedOption.dataset.price);
        document.getElementById('selected-menu').textContent = selectedOption.dataset.name;
        document.getElementById('unit-price').textContent = 'Rp ' + selectedPrice.toLocaleString('id-ID');
        updateTotal();
    } else {
        selectedPrice = 0;
        document.getElementById('selected-menu').textContent = '-';
        document.getElementById('unit-price').textContent = '-';
        updateTotal();
    }
}

function updateTotal() {
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    const subtotal = selectedPrice * quantity;
    const orderType = document.getElementById('order_type').value;
    
    // Update quantity display
    document.getElementById('selected-quantity').textContent = quantity;
    
    // Update subtotal
    document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    
    // Update delivery fee
    const deliveryFeeDisplay = orderType === 'delivery' ? deliveryFee : 0;
    document.getElementById('delivery-fee').textContent = 'Rp ' + deliveryFeeDisplay.toLocaleString('id-ID');
    
    // Update total
    const total = subtotal + deliveryFeeDisplay;
    document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function toggleOrderFields() {
    const orderType = document.getElementById('order_type').value;
    const deliveryFields = document.getElementById('delivery-fields');
    const dineinFields = document.getElementById('dinein-fields');
    
    // Hide all fields first
    deliveryFields.style.display = 'none';
    dineinFields.style.display = 'none';
    
    // Show relevant fields
    if (orderType === 'delivery') {
        deliveryFields.style.display = 'block';
    } else if (orderType === 'dine-in') {
        dineinFields.style.display = 'block';
    }
    
    updateTotal();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePrice();
    updateTotal();
});
</script>
@endsection