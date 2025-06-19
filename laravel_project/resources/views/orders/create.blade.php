<x-app-layout>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Form Pemesanan</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="menu_id" class="form-label">Pilih Menu</label>
                <select name="menu_id" id="menu_id" class="form-select" required></select>
                    <option value="">-- Pilih Menu --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}" data-img="{{ asset('storage/' . $menu->image) }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
                            {{ $menu->name }} - Rp{{ number_format($menu->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Catatan Khusus (Opsional)</label>
                <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="order_type" class="form-label">Tipe Order</label>
                <select name="order_type" id="order_type" class="form-select" required onchange="toggleOrderFields()">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="dine-in" {{ old('order_type') == 'dine-in' ? 'selected' : '' }}>Dine-in</option>
                    <option value="takeaway" {{ old('order_type') == 'takeaway' ? 'selected' : '' }}>Takeaway</option>
                    <option value="delivery" {{ old('order_type') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                </select>
            </div>
            <div class="mb-3" id="table_number_field" style="display:none;">
                <label for="table_number" class="form-label">Nomor Meja</label>
                <input type="text" class="form-control" id="table_number" name="table_number" value="{{ old('table_number') }}">
            </div>
            <div class="mb-3" id="address_field" style="display:none;">
                <label for="address" class="form-label">Alamat Pengantaran</label>
                <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="ewallet" {{ old('payment_method') == 'ewallet' ? 'selected' : '' }}>E-wallet</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit Order</button>
            <button type="button" class="btn btn-secondary mt-3 ms-2" onclick="window.print()">Cetak Struk</button>
        </form>
    </div>
</div>
<script>
function toggleOrderFields() {
    var type = document.getElementById('order_type').value;
    document.getElementById('table_number_field').style.display = (type === 'dine-in') ? 'block' : 'none';
    document.getElementById('address_field').style.display = (type === 'delivery') ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', function() {
    toggleOrderFields();
});
</script>
</x-app-layout>
