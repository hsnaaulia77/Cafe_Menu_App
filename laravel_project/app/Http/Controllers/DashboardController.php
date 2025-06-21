<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik menu
        $totalMenus = Menu::count();
        $availableMenus = Menu::where('status', 'Tersedia')->count();
        $unavailableMenus = Menu::where('status', 'Tidak tersedia')->count();
        
        // Statistik pesanan
        $totalOrders = Order::count();
        
        // Menu terbaru (5 menu terakhir)
        $recentMenus = Menu::latest()->take(5)->get();
        
        // Pesanan terbaru (5 pesanan terakhir)
        $recentOrders = Order::latest()->take(5)->get();
        
        // Menu berdasarkan kategori
        $menuCategories = Menu::selectRaw('kategori, count(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori')
            ->toArray();
        
        return view('dashboard', compact(
            'totalMenus',
            'availableMenus', 
            'unavailableMenus',
            'totalOrders',
            'recentMenus',
            'recentOrders',
            'menuCategories'
        ));
    }
} 