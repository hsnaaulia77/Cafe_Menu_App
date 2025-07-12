@extends('layouts.app')

@section('content')
<style>
    body { background: #181a23; }
    .order-create-card {
        background: rgba(30,32,40,0.98);
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
        color: #ffd700;
        max-width: 900px;
        margin: 40px auto 0 auto;
        padding: 2.5rem 2rem 2rem 2rem;
    }
    .order-create-card h1 {
        color: #ffd700;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .order-label { color: #ffd700; font-weight: 600; margin-bottom: 0.3rem; display: block; }
    .order-input, .order-select {
        width: 100%;
        padding: 0.7rem 1rem;
        border-radius: 8px;
        border: none;
        background: #23263a;
        color: #fff;
        margin-bottom: 1.1rem;
        font-size: 1rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .order-input:focus, .order-select:focus {
        outline: 2px solid #ffd700;
        background: #23263a;
    }
    .order-btn {
        background: linear-gradient(90deg,#ffd700 0%,#e6c200 100%);
        color: #181a23;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        padding: 0.85rem 0;
        font-size: 1.1rem;
        margin-top: 0.5rem;
        box-shadow: 0 2px 8px rgba(255,215,0,0.08);
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .order-btn:hover {
        background: linear-gradient(90deg,#e6c200 0%,#ffd700 100%);
        color: #23263a;
        box-shadow: 0 4px 16px rgba(255,215,0,0.13);
    }
    .order-alert {
        background: #23263a;
        color: #ffd700;
        border-radius: 8px;
        padding: 0.8rem 1rem;
        margin-bottom: 1.2rem;
        font-weight: 600;
        text-align: center;
        border: 1px solid #ffd70033;
        box-shadow: 0 1px 4px rgba(255,215,0,0.04);
    }
    .order-table {
        color: #ffd700;
        background: transparent;
        border-radius: 1rem;
        overflow: hidden;
    }
    .order-table th, .order-table td {
        background: rgba(24,24,28,0.85);
        border: none;
        padding: 0.7em 0.7em;
        vertical-align: middle;
    }
    .order-table tr:hover { background: #23263a; color: #fff; }
    .order-table .btn-danger { background: #e53935; color: #fff; border: none; border-radius: 0.7em; }
    .order-table .btn-danger:hover { opacity: 0.85; }
    .order-table .btn-primary { background: #ffd700; color: #181a23; border: none; border-radius: 0.7em; }
    .order-table .btn-primary:hover { background: #e6c200; color: #23263a; }
    @media (max-width: 900px) {
        .order-create-card { padding: 1.2rem 0.7rem 1.5rem 0.7rem; max-width: 98vw; }
        .order-create-card h1 { font-size: 1.1rem; }
        .order-table th, .order-table td { font-size: 0.92em; padding: 0.5em 0.3em; }
    }
</style>
<div class="order-create-card">
    <h1><i class="fas fa-plus"></i> Buat Order Baru</h1>
    @if(session('success'))
        <div class="order-alert">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="order-alert" style="color:#ff6b6b;background:#23263a;">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="table_id" class="order-label">Nomor Meja</label>
                <select name="table_id" id="table_id" class="order-select" required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">Meja {{ $table->nomor_meja }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="customer_name" class="order-label">Nama Customer</label>
                <input type="text" name="customer_name" id="customer_name" class="order-input" placeholder="Opsional">
            </div>
            <div class="col-md-4">
                <label for="order_datetime" class="order-label">Tanggal/Waktu Order</label>
                <input type="text" name="order_datetime" id="order_datetime" class="order-input" value="{{ now() }}" readonly>
            </div>
        </div>
        <h5 style="color:#ffd700;">Item Pesanan</h5>
        <table class="table order-table" id="orderItemsTable">
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
                        <select name="items[0][menu_item_id]" class="order-select menu-select" required>
                            <option value="">-- Pilih Menu --</option>
                            @foreach($menuItems as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->harga }}">{{ $item->nama }} (Rp {{ number_format($item->harga) }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[0][quantity]" class="order-input qty-input" min="1" value="1" required></td>
                    <td><input type="text" class="order-input price-input" value="0" readonly></td>
                    <td><input type="text" class="order-input subtotal-input" value="0" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary mb-3" id="addRow">Tambah Item</button>
        <div class="mb-3">
            <label for="total" class="order-label">Total Harga</label>
            <input type="text" name="total" id="total" class="order-input" value="0" readonly>
        </div>
        <button type="submit" class="order-btn"><i class="fas fa-save"></i> Simpan Order</button>
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