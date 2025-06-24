<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Order #{{ $order->id }}</title>
    <meta name="viewport" content="width=320">
    <style>
        body {
            width: 58mm;
            max-width: 58mm;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0 auto;
            background: #fff;
            color: #222;
        }
        .receipt {
            padding: 8px 0;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin-bottom: 4px;
        }
        .line {
            border-top: 1px dashed #222;
            margin: 6px 0;
        }
        .items th, .items td {
            padding: 2px 0;
        }
        .items th {
            border-bottom: 1px solid #222;
        }
        .totals td {
            padding: 2px 0;
        }
        .footer {
            margin-top: 10px;
            font-size: 11px;
        }
        .cafe-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .cafe-tagline {
            font-size: 10px;
            font-style: italic;
            margin-bottom: 4px;
        }
        .status-badge {
            background: #000;
            color: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        @media print {
            body { width: 58mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="center">
        @if(file_exists(public_path('images/logo.png')))
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        @endif
        <div class="cafe-name">CAFFEE MENU</div>
        <div class="cafe-tagline">Fresh Coffee & Delicious Food</div>
        <div>Jl. Raya Utama No. 45</div>
        <div>Jakarta Selatan, 12345</div>
        <div>Telp: (021) 555-0123</div>
        <div>Email: info@caffeemenu.com</div>
    </div>
    <div class="line"></div>
    <table width="100%">
        <tr>
            <td>No. Order</td>
            <td class="bold" align="right">#{{ $order->id }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td align="right">{{ $order->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td align="right">{{ $order->created_at->format('H:i') }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td align="right">{{ $order->user->name ?? 'Admin' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td align="right">
                <span class="status-badge">{{ $order->status_label }}</span>
            </td>
        </tr>
    </table>
    @if($order->customer_name)
    <div class="line"></div>
    <div class="bold">Customer:</div>
    <div>{{ $order->customer_name }}</div>
    @if($order->customer_phone)
    <div>Telp: {{ $order->customer_phone }}</div>
    @endif
    @if($order->customer_address)
    <div>Alamat: {{ $order->customer_address }}</div>
    @endif
    @endif
    <div class="line"></div>
    <table width="100%" class="items">
        <thead>
            <tr>
                <th align="left">Item</th>
                <th align="center">Qty</th>
                <th align="right">Harga</th>
                <th align="right">Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->menu->name }}</td>
                <td align="center">{{ $item->quantity }}</td>
                <td align="right">{{ number_format($item->price, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @if($item->notes)
            <tr>
                <td colspan="4" style="font-size: 10px; padding-left: 10px;">
                    Note: {{ $item->notes }}
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <div class="line"></div>
    <table width="100%" class="totals">
        <tr>
            <td class="bold">TOTAL</td>
            <td align="right" class="bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
        </tr>
        @if($order->paid_amount)
        <tr>
            <td>Bayar</td>
            <td align="right">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td align="right">Rp {{ number_format(max(0, $order->paid_amount - $order->total_amount), 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr>
            <td>Metode Bayar</td>
            <td align="right">{{ $order->payment_method_label }}</td>
        </tr>
    </table>
    @if($order->notes)
    <div class="line"></div>
    <div class="bold">Catatan:</div>
    <div style="font-size: 11px;">{{ $order->notes }}</div>
    @endif
    <div class="line"></div>
    <div class="center footer">
        <div class="bold">Terima Kasih</div>
        <div>Atas Kunjungan Anda</div>
        <div style="margin-top: 5px;">---</div>
        <div>{{ now()->format('d/m/Y H:i:s') }}</div>
        <div style="margin-top: 5px;">Barang yang sudah dibeli</div>
        <div>tidak dapat dikembalikan</div>
    </div>
    <div class="center no-print" style="margin-top:10px;">
        <button onclick="window.print()" style="padding: 5px 10px; margin: 2px;">Print Struk</button>
        <a href="{{ url()->previous() }}" style="padding: 5px 10px; margin: 2px; text-decoration: none; background: #f0f0f0; color: #333;">Kembali</a>
    </div>
</div>
</body>
</html> 