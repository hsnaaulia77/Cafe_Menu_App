<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;

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
        $menus = Menu::where('is_available', true)->get();
        return view('orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        
        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_amount = $menu->price * $request->quantity;
        $order->status = 'pending';
        $order->notes = $request->notes;
        $order->save();

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => $request->quantity,
            'price' => $menu->price
        ]);

        return redirect()->route('orders.index')
                        ->with('success', 'Order placed successfully!');
    }
}
