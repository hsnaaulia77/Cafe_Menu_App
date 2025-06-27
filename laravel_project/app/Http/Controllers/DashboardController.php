<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Table;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $orderToday = Order::whereDate('order_datetime', $today)->count();
        $menuTerjual = Order::whereDate('order_datetime', $today)->with('items')->get()->flatMap->items->sum('quantity');
        $mejaAktif = Table::where('status', 'digunakan')->count();
        $pendapatan = Order::whereDate('order_datetime', $today)->where('status', 'selesai')->sum('total');
        $menuFavorit = MenuItem::withCount(['orderItems as total_terjual' => function($q) use ($today) {
            $q->whereHas('order', function($q2) use ($today) {
                $q2->whereDate('order_datetime', $today);
            });
        }])->orderByDesc('total_terjual')->take(3)->get();

        return view('dashboard', compact('orderToday', 'menuTerjual', 'mejaAktif', 'pendapatan', 'menuFavorit'));
    }
}
