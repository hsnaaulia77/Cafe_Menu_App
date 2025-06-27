@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Order Baru</h1>
    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="table_id" class="form-label">Nomor Meja</label>
                <select name="table_id" id="table_id" class="form-control" required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">Meja {{ $table->nomor_meja }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="customer_name" class="form-label">Nama Customer</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Opsional">
            </div>
            <div class="col-md-4">
                <label for="order_datetime" class="form-label">Tanggal/Waktu Order</label>
                <input type="text" name="order_datetime" id="order_datetime" class="form-control" value="{{ now() }}" readonly>
            </div>
        </div>
        <h5>Item Pesanan</h5>
        <table class="table" id="orderItemsTable">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][menu_item_id]" class="form-control menu-select" required>
                            <option value="">-- Pilih Menu --</option>
                            @foreach($menuItems as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->harga }}">{{ $item->nama }} (Rp {{ number_format($item->harga) }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[0][quantity]" class="form-control qty-input" min="1" value="1" required></td>
                    <td><input type="text" class="form-control price-input" value="0" readonly></td>
                    <td><input type="text" class="form-control subtotal-input" value="0" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary mb-3" id="addRow">Tambah Item</button>
        <div class="mb-3">
            <label for="total" class="form-label">Total Harga</label>
            <input type="text" name="total" id="total" class="form-control" value="0" readonly>
        </div>
        <button type="submit" class="btn btn-success">Simpan Order</button>
    </form>
</div>

<script>
let rowIdx = 1;
const menuItems = @json($menuItems);

function updateSubtotal(row) {
    const qty = parseInt(row.find('.qty-input').val()) || 0;
    const price = parseInt(row.find('.price-input').val()) || 0;
    row.find('.subtotal-input').val(qty * price);
    updateTotal();
}

function updateTotal() {
    let total = 0;
    $('#orderItemsTable tbody tr').each(function() {
        total += parseInt($(this).find('.subtotal-input').val()) || 0;
    });
    $('#total').val(total);
}

$(document).on('change', '.menu-select', function() {
    const price = $(this).find('option:selected').data('price') || 0;
    const row = $(this).closest('tr');
    row.find('.price-input').val(price);
    updateSubtotal(row);
});

$(document).on('input', '.qty-input', function() {
    const row = $(this).closest('tr');
    updateSubtotal(row);
});

$('#addRow').click(function() {
    const newRow = $('#orderItemsTable tbody tr:first').clone();
    newRow.find('select, input').each(function() {
        const name = $(this).attr('name');
        if (name) {
            const newName = name.replace(/items\[\d+\]/, `items[${rowIdx}]`);
            $(this).attr('name', newName);
        }
        if ($(this).is('select')) $(this).val('');
        else $(this).val(1);
        if ($(this).hasClass('price-input') || $(this).hasClass('subtotal-input')) $(this).val(0);
    });
    $('#orderItemsTable tbody').append(newRow);
    rowIdx++;
});

$(document).on('click', '.remove-row', function() {
    if ($('#orderItemsTable tbody tr').length > 1) {
        $(this).closest('tr').remove();
        updateTotal();
    }
});
</script>
@endsection 