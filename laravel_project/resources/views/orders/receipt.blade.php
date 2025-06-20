<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .queue-number { font-size: 32px; font-weight: bold; margin: 10px 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background: #f2f2f2; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
        .signature { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature-box { width: 45%; text-align: center; }
        .item-notes { font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height:60px;">
        <h2>Caffee Menu App</h2>
        <p>Jl. Contoh Alamat No. 123, Kota Kopi</p>
        <p>Telp: 0812-3456-7890</p>
        <hr>
        <div class="queue-number">
            {{ $order->queue_number ?? $order->id }}
        </div>
        <p><strong>Struk Pesanan #{{ $order->id }}</strong></p>
        <p>Tanggal: {{ $order->created_at->format('d-m-Y H:i') }}</p>
        @if(isset($order->user) && $order->user)
            <p>Kasir: {{ $order->user->name }}</p>
        @endif
        @if($order->customer_name)
            <p>Pelanggan: {{ $order->customer_name }}</p>
        @endif
    </div>

    <hr style="border:1px dashed #aaa;">

    <table>
        <tr>
            <td><strong>Tipe Order</strong></td>
            <td>{{ ucfirst($order->order_type) }}</td>
        </tr>
        @if($order->order_type == 'dine-in')
        <tr>
            <td><strong>Nomor Meja</strong></td>
            <td>{{ $order->table_number }}</td>
        </tr>
        @endif
        @if($order->order_type == 'delivery')
        <tr>
            <td><strong>Alamat</strong></td>
            <td>{{ $order->address }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Metode Pembayaran</strong></td>
            <td>{{ ucfirst($order->payment_method) }}</td>
        </tr>
        @if($order->notes)
        <tr>
            <td><strong>Catatan</strong></td>
            <td>{{ $order->notes }}</td>
        </tr>
        @endif
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item->menu->name }}
                    @if($item->notes)
                        <div class="item-notes">Catatan: {{ $item->notes }}</div>
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td style="text-align:right;">Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                <td style="text-align:right;">Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                $subtotal = $order->items->sum(function($item){ return $item->menu->price * $item->quantity; });
                $discount = $order->discount ?? 0; // nominal
                $tax_percent = $order->tax_percent ?? 10; // default 10%
                $tax = ($subtotal - $discount) * $tax_percent / 100;
                $service_charge = $order->service_charge ?? 0; // nominal
                $total = $subtotal - $discount + $tax + $service_charge;
            @endphp
            <tr>
                <th colspan="3" style="text-align:right;">Subtotal</th>
                <th style="text-align:right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</th>
            </tr>
            @if($discount > 0)
            <tr>
                <th colspan="3" style="text-align:right;">Diskon/Promo</th>
                <th style="text-align:right;">- Rp {{ number_format($discount, 0, ',', '.') }}</th>
            </tr>
            @endif
            <tr>
                <th colspan="3" style="text-align:right;">Pajak ({{ $tax_percent }}%)</th>
                <th style="text-align:right;">Rp {{ number_format($tax, 0, ',', '.') }}</th>
            </tr>
            @if($service_charge > 0)
            <tr>
                <th colspan="3" style="text-align:right;">Service Charge</th>
                <th style="text-align:right;">Rp {{ number_format($service_charge, 0, ',', '.') }}</th>
            </tr>
            @endif
            <tr>
                <th colspan="3" style="text-align:right;">Total</th>
                <th style="text-align:right;">Rp {{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="text-align:center;">
        {!! QrCode::size(80)->generate('https://cafe-app.com/order/'.$order->id) !!}
        <p style="font-size:12px;">Scan untuk cek status pesanan</p>
    </div>

    <div class="signature">
        <div class="signature-box">
            <p>Kasir</p>
            <br><br>
            <p>_________________________</p>
        </div>
        <div class="signature-box">
            <p>Pelanggan</p>
            <br><br>
            <p>_________________________</p>
        </div>
    </div>

    <div class="footer">
        <hr>
        <p>Terima kasih atas pesanan Anda!</p>
    </div>
</body>
</html>
