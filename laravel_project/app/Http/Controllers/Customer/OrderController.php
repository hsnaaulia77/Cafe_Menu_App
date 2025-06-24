<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('customer.orders.index');
    }

    public function create()
    {
        if (auth()->user()->role !== 'customer') {
            abort(403, 'Unauthorized');
        }
        $menus = \App\Models\Menu::all();
        return view('customer.orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'customer') {
            abort(403, 'Unauthorized');
        }
        // Validasi dan simpan pesanan ke cart atau langsung ke order
        // Contoh sederhana:
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);
        // Simpan ke cart (atau langsung ke order sesuai flow aplikasi)
        // ... kode simpan ...
        return redirect()->route('orders.checkout');
    }

    public function checkout()
    {
        $cart = []; // Ambil data cart user
        $total = 0; // Hitung total
        // ... kode ambil cart dan total ...
        return view('customer.orders.checkout', compact('cart', 'total'));
    }

    public function history()
    {
        $orders = []; // Ambil riwayat pesanan user
        // ... kode ambil orders ...
        return view('customer.orders.history', compact('orders'));
    }
} 