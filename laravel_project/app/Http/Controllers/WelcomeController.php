<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Statistik untuk welcome page
        $totalMenus = Menu::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        
        return view('welcome', compact('totalMenus', 'totalOrders', 'totalUsers'));
    }
} 