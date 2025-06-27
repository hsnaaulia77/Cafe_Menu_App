<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'items.menuItem'])->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $tables = Table::all();
        $menuItems = MenuItem::all();
        return view('orders.create', compact('tables', 'menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'table_id' => $request->table_id,
                'customer_name' => $request->customer_name,
                'order_datetime' => now(),
                'total' => 0, // akan diupdate setelah item
                'status' => 'menunggu',
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $menu = MenuItem::findOrFail($item['menu_item_id']);
                $subtotal = $menu->harga * $item['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'price' => $menu->harga,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $order->update(['total' => $total]);
            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Order berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menyimpan order: ' . $e->getMessage()])->withInput();
        }
    }
} 