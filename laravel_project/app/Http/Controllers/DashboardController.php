<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Table;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Statistik kunjungan 7 hari terakhir
        $ordersPerDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $labels = [];
        $data = [];
        $period = \Carbon\CarbonPeriod::create(now()->subDays(6), now());
        foreach ($period as $date) {
            $tgl = $date->format('Y-m-d');
            $labels[] = $date->isoFormat('ddd');
            $found = $ordersPerDay->firstWhere('date', $tgl);
            $data[] = $found ? $found->total : 0;
        }
        $kunjunganData = [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Kunjungan',
                'data' => $data,
                'backgroundColor' => 'rgba(255, 215, 0, 0.5)',
                'borderColor' => 'rgba(255, 215, 0, 1)',
                'borderWidth' => 2,
                'tension' => 0.4
            ]]
        ];
        // Statistik menu terlaris
        $menuTerlaris = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->selectRaw('menu_items.nama, SUM(order_items.quantity) as total')
            ->groupBy('menu_items.nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $menuTerlarisData = [
            'labels' => $menuTerlaris->pluck('nama'),
            'datasets' => [[
                'label' => 'Penjualan',
                'data' => $menuTerlaris->pluck('total'),
                'backgroundColor' => [
                    'rgba(255, 215, 0, 0.7)',
                    'rgba(184, 115, 51, 0.7)',
                    'rgba(60, 60, 60, 0.7)',
                    'rgba(0, 200, 83, 0.7)',
                    'rgba(0, 123, 255, 0.7)'
                ],
                'borderColor' => 'rgba(255, 255, 255, 1)',
                'borderWidth' => 1
            ]]
        ];
        // Status meja
        $mejaTersedia = Table::where('status', 'available')->count();
        $totalMeja = Table::count();
        // Aktivitas terbaru (pagination)
        $activities = Order::with('customer')->orderByDesc('created_at')->paginate(10);
        // Stok menu hampir habis
        $lowStockMenus = MenuItem::where('stok', '<=', 5)->orderBy('stok')->get();
        // Menu promo
        $promoMenus = MenuItem::whereNotNull('label_promo')->get();
        return view('dashboard', compact(
            'activities', 'lowStockMenus', 'promoMenus',
            'kunjunganData', 'menuTerlarisData', 'mejaTersedia', 'totalMeja'
        ));
    }

    // AJAX search suggest
    public function searchSuggest(Request $request)
    {
        $q = $request->get('q', '');
        $results = [];
        if(strlen($q) > 1) {
            $orders = Order::where('order_number', 'like', "%$q%")
                ->pluck('order_number');
            $customers = class_exists(Customer::class)
                ? Customer::where('name', 'like', "%$q%")
                    ->pluck('name')
                : collect();
            $menus = MenuItem::where('name', 'like', "%$q%")
                ->pluck('name');
            $results = $orders->merge($customers)->merge($menus)->unique()->take(10)->values();
        }
        return response()->json($results);
    }

    // Export Excel (dummy)
    public function exportExcel()
    {
        return response('Export Excel belum diimplementasi', 200);
    }
    // Export PDF (dummy)
    public function exportPdf()
    {
        return response('Export PDF belum diimplementasi', 200);
    }
}
