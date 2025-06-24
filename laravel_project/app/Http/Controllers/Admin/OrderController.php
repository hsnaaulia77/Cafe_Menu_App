<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'orderItems.menu']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by user/kasir
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by total amount range
        if ($request->filled('total_min')) {
            $query->where('total_amount', '>=', $request->total_min);
        }
        if ($request->filled('total_max')) {
            $query->where('total_amount', '<=', $request->total_max);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'paid') {
                $query->whereNotNull('paid_amount')->where('paid_amount', '>', 0);
            } elseif ($request->payment_status == 'unpaid') {
                $query->where(function($q) {
                    $q->whereNull('paid_amount')->orWhere('paid_amount', 0);
                });
            }
        }

        // Search by customer name or order ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris,card',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount' => $request->total_amount,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'orderItems.menu']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris,card',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        $order->update($request->all());

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        if ($order->status === 'completed') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order yang sudah selesai tidak dapat dihapus!');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order berhasil dihapus!');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,ready,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Update timestamps based on status
        $updateData = [
            'status' => $newStatus,
            'admin_notes' => $request->admin_notes,
        ];

        if ($newStatus === 'processing' && $oldStatus !== 'processing') {
            $updateData['processed_at'] = now();
        }

        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $updateData['completed_at'] = now();
        }

        $order->update($updateData);

        $statusLabel = $order->status_label;
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', "Status order berhasil diubah menjadi {$statusLabel}!");
    }

    /**
     * Mark order as paid
     */
    public function markAsPaid(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $order->update([
            'paid_amount' => $request->paid_amount,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pembayaran berhasil dicatat!');
    }

    /**
     * Dashboard statistics
     */
    public function dashboard(): View
    {
        $today = now()->startOfDay();
        
        $stats = [
            'total_orders' => Order::count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::whereIn('status', ['processing', 'ready'])->count(),
            'completed_today' => Order::where('status', 'completed')
                ->whereDate('completed_at', today())->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'today_revenue' => Order::where('status', 'completed')
                ->whereDate('completed_at', today())->sum('total_amount'),
        ];

        $recentOrders = Order::with(['user', 'orderItems.menu'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.orders.dashboard', compact('stats', 'recentOrders'));
    }

    public function print(Order $order)
    {
        $order->load(['user', 'orderItems.menu']);
        return view('admin.orders.print', compact('order'));
    }

    /**
     * Export orders to Excel
     */
    public function exportExcel(Request $request)
    {
        $orders = $this->getFilteredOrders($request);
        
        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $content = $this->generateExcelContent($orders);
        
        return response($content, 200, $headers);
    }

    /**
     * Export orders to CSV
     */
    public function exportCsv(Request $request)
    {
        $orders = $this->getFilteredOrders($request);
        
        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $content = $this->generateCsvContent($orders);
        
        return response($content, 200, $headers);
    }

    /**
     * Export orders to PDF
     */
    public function exportPdf(Request $request)
    {
        $orders = $this->getFilteredOrders($request);
        
        $pdf = PDF::loadView('admin.orders.pdf', compact('orders'));
        
        return $pdf->download('orders_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Get filtered orders for export
     */
    private function getFilteredOrders(Request $request)
    {
        $query = Order::with(['user', 'orderItems.menu']);

        // Apply same filters as index method
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('total_min')) {
            $query->where('total_amount', '>=', $request->total_min);
        }
        if ($request->filled('total_max')) {
            $query->where('total_amount', '<=', $request->total_max);
        }
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'paid') {
                $query->whereNotNull('paid_amount')->where('paid_amount', '>', 0);
            } elseif ($request->payment_status == 'unpaid') {
                $query->where(function($q) {
                    $q->whereNull('paid_amount')->orWhere('paid_amount', 0);
                });
            }
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        return $query->latest()->get();
    }

    /**
     * Generate Excel content
     */
    private function generateExcelContent($orders)
    {
        $content = "<table border='1'>\n";
        
        // Header
        $content .= "<tr>\n";
        $content .= "<th>ID</th>\n";
        $content .= "<th>Customer</th>\n";
        $content .= "<th>Telepon</th>\n";
        $content .= "<th>Total</th>\n";
        $content .= "<th>Status</th>\n";
        $content .= "<th>Metode Bayar</th>\n";
        $content .= "<th>Dibayar</th>\n";
        $content .= "<th>Kasir</th>\n";
        $content .= "<th>Tanggal</th>\n";
        $content .= "</tr>\n";
        
        // Data
        foreach ($orders as $order) {
            $content .= "<tr>\n";
            $content .= "<td>#" . $order->id . "</td>\n";
            $content .= "<td>" . htmlspecialchars($order->customer_name) . "</td>\n";
            $content .= "<td>" . htmlspecialchars($order->customer_phone) . "</td>\n";
            $content .= "<td>Rp " . number_format($order->total_amount, 0, ',', '.') . "</td>\n";
            $content .= "<td>" . $order->status_label . "</td>\n";
            $content .= "<td>" . $order->payment_method_label . "</td>\n";
            $content .= "<td>Rp " . number_format($order->paid_amount ?? 0, 0, ',', '.') . "</td>\n";
            $content .= "<td>" . htmlspecialchars($order->user->name ?? 'Admin') . "</td>\n";
            $content .= "<td>" . $order->created_at->format('d/m/Y H:i') . "</td>\n";
            $content .= "</tr>\n";
        }
        
        $content .= "</table>";
        
        return $content;
    }

    /**
     * Generate CSV content
     */
    private function generateCsvContent($orders)
    {
        $output = fopen('php://temp', 'r+');
        
        // Header
        fputcsv($output, [
            'ID', 'Customer', 'Telepon', 'Total', 'Status', 
            'Metode Bayar', 'Dibayar', 'Kasir', 'Tanggal'
        ]);
        
        // Data
        foreach ($orders as $order) {
            fputcsv($output, [
                '#' . $order->id,
                $order->customer_name,
                $order->customer_phone,
                'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                $order->status_label,
                $order->payment_method_label,
                'Rp ' . number_format($order->paid_amount ?? 0, 0, ',', '.'),
                $order->user->name ?? 'Admin',
                $order->created_at->format('d/m/Y H:i')
            ]);
        }
        
        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);
        
        return $content;
    }

    /**
     * Bulk action: update status or delete multiple orders
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'order_ids' => 'required|array',
            'bulk_action' => 'required|in:update_status,delete',
            'status' => 'required_if:bulk_action,update_status|in:pending,confirmed,processing,ready,completed,cancelled',
        ], [
            'order_ids.required' => 'Pilih minimal satu order.',
            'bulk_action.required' => 'Pilih aksi massal.',
            'status.required_if' => 'Pilih status baru.',
        ]);

        $orderIds = $request->order_ids;
        $action = $request->bulk_action;
        $count = 0;

        if ($action === 'update_status') {
            $count = Order::whereIn('id', $orderIds)
                ->update(['status' => $request->status]);
            $msg = "$count order berhasil diubah statusnya.";
        } elseif ($action === 'delete') {
            // Hanya hapus order yang belum selesai
            $orders = Order::whereIn('id', $orderIds)->where('status', '!=', 'completed')->get();
            $count = $orders->count();
            foreach ($orders as $order) {
                $order->delete();
            }
            $msg = "$count order berhasil dihapus.";
        } else {
            return back()->with('error', 'Aksi tidak valid.');
        }

        return redirect()->route('admin.orders.index')->with('success', $msg);
    }

    /**
     * Halaman POS untuk kasir: input pesanan cepat
     */
    public function pos()
    {
        $menus = \App\Models\Menu::with('kategori')->orderBy('nama')->get();
        $categories = \App\Models\KategoriMenu::orderBy('nama')->get();
        return view('orders.pos', compact('menus', 'categories'));
    }
}
