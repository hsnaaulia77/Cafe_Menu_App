<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuItems = MenuItem::with(['kategori', 'promotions'])->orderBy('created_at', 'desc')->paginate(10);
        return view('menu_items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'tersedia')->get();
        $allPromotions = \App\Models\Promotion::where('status', 'aktif')->orderBy('nama')->get();
        return view('menu_items.create', compact('categories', 'allPromotions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:tersedia,tidak tersedia',
            'stok' => 'nullable|integer|min:0',
            'promo_aktif' => 'required|in:aktif,tidak_aktif',
        ]);
        $data = $request->only('nama', 'kategori_id', 'deskripsi', 'harga', 'status', 'stok', 'promo_aktif');
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menu_items', 'public');
        }
        $menuItem = MenuItem::create($data);
        // Attach promotions if selected
        if ($request->has('promotion_ids')) {
            $menuItem->promotions()->sync($request->input('promotion_ids', []));
        }
        return redirect()->route('menu_items.index')->with('success', 'Menu item berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menuItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $categories = Category::where('status', 'tersedia')->get();
        $allPromotions = \App\Models\Promotion::where('status', 'aktif')->orderBy('nama')->get();
        $menuItem->load('promotions');
        return view('menu_items.edit', compact('menuItem', 'categories', 'allPromotions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:tersedia,tidak tersedia',
            'stok' => 'nullable|integer|min:0',
            'promo_aktif' => 'required|in:aktif,tidak_aktif',
        ]);
        $data = $request->only('nama', 'kategori_id', 'deskripsi', 'harga', 'status', 'stok', 'promo_aktif');
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menuItem->gambar) {
                Storage::disk('public')->delete($menuItem->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('menu_items', 'public');
        }
        $menuItem->update($data);
        // Sync promotions if selected
        if ($request->has('promotion_ids')) {
            $menuItem->promotions()->sync($request->input('promotion_ids', []));
        } else {
            $menuItem->promotions()->sync([]);
        }
        return redirect()->route('menu_items.index')->with('success', 'Menu item berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->gambar) {
            Storage::disk('public')->delete($menuItem->gambar);
        }
        $menuItem->delete();
        return redirect()->route('menu_items.index')->with('success', 'Menu item berhasil dihapus!');
    }

    public function editPromotions($id)
    {
        $menuItem = \App\Models\MenuItem::with('promotions')->findOrFail($id);
        $allPromotions = \App\Models\Promotion::all();
        return view('menu_items.edit_promotions', compact('menuItem', 'allPromotions'));
    }

    public function updatePromotions(\Illuminate\Http\Request $request, $id)
    {
        $menuItem = \App\Models\MenuItem::findOrFail($id);
        $menuItem->promotions()->sync($request->input('promotion_ids', []));
        return redirect()->route('menu_items.index')->with('success', 'Promosi menu berhasil diupdate!');
    }
}
