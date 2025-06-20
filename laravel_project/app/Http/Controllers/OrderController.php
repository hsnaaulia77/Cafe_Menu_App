<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.menu', 'user'])
                      ->where('user_id', auth()->id())
                      ->latest()
                      ->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::all();
        return view('orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|regex:/^08[0-9]{8,13}$/',
            'customer_email' => 'nullable|email',
            'menu_item_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'order_type' => 'required|in:dine-in,takeaway,delivery',
            'table_number' => 'nullable|string',
            'address' => 'nullable|string',
            'payment_method' => 'required|in:cash,qris,transfer,ewallet',
        ]);

        // Contoh: ambil dari request atau set default
        $discount = $request->input('discount', 0);
        $tax_percent = $request->input('tax_percent', 10);
        $service_charge = $request->input('service_charge', 0);
        $queue_number = $request->input('queue_number'); // bisa auto-generate jika perlu

        // Simpan order
        $order = Order::create([
            'order_type' => $validated['order_type'],
            'table_number' => $validated['order_type'] === 'dine-in' ? $validated['table_number'] : null,
            'address' => $validated['order_type'] === 'delivery' ? $validated['address'] : null,
            'notes' => $validated['notes'] ?? null,
            'payment_method' => $validated['payment_method'],
            'discount' => $discount,
            'tax_percent' => $tax_percent,
            'service_charge' => $service_charge,
            'queue_number' => $queue_number,
        ]);

        // Simpan item pesanan
        $menu = Menu::findOrFail($validated['menu_item_id']);
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $validated['menu_item_id'],
            'quantity' => $validated['quantity'],
            'price' => $menu->price,
            'notes' => $request->input('item_notes'),
        ]);

        return redirect()->route('orders.create')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function print($orderId)
    {
        $order = Order::with(['items.menu', 'user'])->findOrFail($orderId);
        // Hitung total, diskon, pajak, service charge di controller jika perlu
        $pdf = PDF::loadView('orders.receipt', compact('order'));
        return $pdf->download('struk-pesanan-'.$order->id.'.pdf');
    }
}
