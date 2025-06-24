<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Services\AuditService;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MenusExport;
use App\Imports\MenusImport;

class MenuController extends Controller
{
    protected $auditService;
    protected $encryptionService;

    public function __construct(AuditService $auditService, EncryptionService $encryptionService)
    {
        $this->auditService = $auditService;
        $this->encryptionService = $encryptionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->canRead('menu')) {
            abort(403, 'Insufficient permissions to view menus.');
        }

        $query = Menu::with('kategoriMenu');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $menus = $query->paginate(12);
        $kategoris = KategoriMenu::all();

        // Log the action
        $this->auditService->log('menu.browse', [
            'description' => 'User browsed menu list',
            'severity' => 'info'
        ]);

        return view('admin.menus.index', compact('menus', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if (!auth()->user()->canCreate('menu')) {
            abort(403, 'Insufficient permissions to create menus.');
        }

        $kategoris = KategoriMenu::all();
        return view('admin.menus.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if (!auth()->user()->canCreate('menu')) {
            abort(403, 'Insufficient permissions to create menus.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = null; // No old values for creation
        $newValues = $request->except(['_token', 'gambar']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/menu-images', $imageName);
            $newValues['gambar'] = 'menu-images/' . $imageName;
        }

        $menu = Menu::create($newValues);

        // Log the creation
        $this->auditService->logModelChange('create', $menu, $oldValues, $newValues);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        // Check permission
        if (!auth()->user()->canRead('menu')) {
            abort(403, 'Insufficient permissions to view menu details.');
        }

        // Log the view
        $this->auditService->log('menu.view', [
            'description' => "User viewed menu: {$menu->nama}",
            'model_type' => 'App\Models\Menu',
            'model_id' => $menu->id,
            'severity' => 'info'
        ]);

        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        // Check permission
        if (!auth()->user()->canUpdate('menu')) {
            abort(403, 'Insufficient permissions to edit menus.');
        }

        $kategoris = KategoriMenu::all();
        return view('admin.menus.edit', compact('menu', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // Check permission
        if (!auth()->user()->canUpdate('menu')) {
            abort(403, 'Insufficient permissions to update menus.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $menu->toArray();
        $newValues = $request->except(['_token', 'gambar']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($menu->gambar && Storage::exists('public/' . $menu->gambar)) {
                Storage::delete('public/' . $menu->gambar);
            }

            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/menu-images', $imageName);
            $newValues['gambar'] = 'menu-images/' . $imageName;
        }

        $menu->update($newValues);

        // Log the update
        $this->auditService->logModelChange('update', $menu, $oldValues, $newValues);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Check permission
        if (!auth()->user()->canDelete('menu')) {
            abort(403, 'Insufficient permissions to delete menus.');
        }

        $oldValues = $menu->toArray();

        // Delete image if exists
        if ($menu->gambar && Storage::exists('public/' . $menu->gambar)) {
            Storage::delete('public/' . $menu->gambar);
        }

        $menu->delete();

        // Log the deletion
        $this->auditService->logModelChange('delete', $menu, $oldValues, null);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Upload gambar menu
     */
    public function uploadGambar(Request $request)
    {
        // Check permission
        if (!auth()->user()->canUpdate('menu')) {
            abort(403, 'Insufficient permissions to upload images.');
        }

        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image file.'
            ], 400);
        }

        $image = $request->file('gambar');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/menu-images', $imageName);

        // Log the upload
        $this->auditService->log('menu.image_upload', [
            'description' => "User uploaded menu image: {$imageName}",
            'severity' => 'info'
        ]);

        return response()->json([
            'success' => true,
            'filename' => 'menu-images/' . $imageName,
            'url' => asset('storage/menu-images/' . $imageName)
        ]);
    }

    /**
     * Display menu for customers
     */
    public function userIndex(Request $request)
    {
        // Check permission
        if (!auth()->user()->canRead('menu')) {
            abort(403, 'Insufficient permissions to view menus.');
        }

        $query = Menu::where('status', 'active');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        $menus = $query->paginate(12);
        $kategoris = KategoriMenu::all();

        // Log the action
        $this->auditService->log('menu.customer_browse', [
            'description' => 'Customer browsed menu',
            'severity' => 'info'
        ]);

        return view('menus.index', compact('menus', 'kategoris'));
    }

    /**
     * Export menu data to Excel.
     */
    public function export()
    {
        if (!auth()->user()->canRead('menu')) {
            abort(403, 'Insufficient permissions.');
        }

        $this->auditService->log('menu.export', [
            'description' => 'User exported menu data',
            'severity' => 'info'
        ]);

        return Excel::download(new MenusExport, 'menus.xlsx');
    }

    /**
     * Import menu data from Excel.
     */
    public function import(Request $request)
    {
        if (!auth()->user()->canCreate('menu')) {
            abort(403, 'Insufficient permissions.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new MenusImport, $request->file('file'));

        $this->auditService->log('menu.import', [
            'description' => 'User imported menu data from a file',
            'severity' => 'warning'
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diimpor!');
    }

    /**
     * Display menu analytics dashboard.
     */
    public function analytics()
    {
        if (!auth()->user()->canRead('report')) {
            abort(403, 'Insufficient permissions to view reports.');
        }

        // --- Data Fetching for Analytics ---

        // 1. Top 5 Best-Selling Menu Items (by quantity)
        $topSellingItems = \App\Models\OrderItem::select('menu_id', \DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('menu_id')
            ->orderBy('total_sold', 'desc')
            ->with('menu')
            ->limit(5)
            ->get();

        // 2. Revenue by Category
        $revenueByCategory = \App\Models\Menu::join('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->join('kategori_menus', 'menus.kategori', '=', 'kategori_menus.id')
            ->select('kategori_menus.nama_kategori', \DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->groupBy('kategori_menus.nama_kategori')
            ->get();

        // 3. Menu Status Distribution (Active vs. Inactive)
        $menuStatus = Menu::select('status', \DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // 4. Daily Sales Trend (last 30 days)
        $salesTrend = \App\Models\OrderItem::select(
                \DB::raw('DATE(created_at) as sale_date'),
                \DB::raw('SUM(price * quantity) as daily_revenue')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('sale_date')
            ->orderBy('sale_date', 'asc')
            ->get();

        // --- Data Preparation for Charts ---

        $categoryLabels = $revenueByCategory->pluck('nama_kategori');
        $categoryData = $revenueByCategory->pluck('total_revenue');

        $salesTrendLabels = $salesTrend->pluck('sale_date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $salesTrendData = $salesTrend->pluck('daily_revenue');

        // Log the action
        $this->auditService->log('report.menu_analytics', [
            'description' => 'User viewed menu analytics dashboard',
            'severity' => 'info'
        ]);

        return view('admin.menus.analytics', compact(
            'topSellingItems',
            'categoryLabels',
            'categoryData',
            'menuStatus',
            'salesTrendLabels',
            'salesTrendData'
        ));
    }
}