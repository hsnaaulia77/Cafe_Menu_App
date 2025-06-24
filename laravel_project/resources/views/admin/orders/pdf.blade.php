<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #8B4513;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-pending { color: #ffc107; }
        .status-confirmed { color: #17a2b8; }
        .status-processing { color: #007bff; }
        .status-ready { color: #28a745; }
        .status-completed { color: #28a745; }
        .status-cancelled { color: #dc3545; }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #8B4513;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CAFFEE MENU</h1>
        <p>Laporan Data Order</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Telepon</th>
                <th>Total</th>
                <th>Status</th>
                <th>Metode Bayar</th>
                <th>Dibayar</th>
                <th>Kasir</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_phone }}</td>
                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="status-{{ $order->status }}">{{ $order->status_label }}</td>
                <td>{{ $order->payment_method_label }}</td>
                <td>Rp {{ number_format($order->paid_amount ?? 0, 0, ',', '.') }}</td>
                <td>{{ $order->user->name ?? 'Admin' }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px;">
                    Tidak ada data order
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Order:</strong> {{ $orders->count() }}</p>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</p>
        <p><strong>Total Dibayar:</strong> Rp {{ number_format($orders->sum('paid_amount'), 0, ',', '.') }}</p>
        <p><strong>Order Selesai:</strong> {{ $orders->where('status', 'completed')->count() }}</p>
        <p><strong>Order Pending:</strong> {{ $orders->where('status', 'pending')->count() }}</p>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat otomatis oleh sistem CAFFEE MENU</p>
        <p>Jl. Raya Utama No. 45, Jakarta Selatan | Telp: (021) 555-0123</p>
    </div>
</body>
</html> 