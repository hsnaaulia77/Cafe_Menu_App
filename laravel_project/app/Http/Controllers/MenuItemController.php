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
        $menuItems = MenuItem::with('kategori')->orderBy('created_at', 'desc')->paginate(10);
        return view('menu_items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'tersedia')->get();
        return view('menu_items.create', compact('categories'));
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
            'status' => 'required|in:aktif,tidak aktif',
            'stok' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('nama', 'kategori_id', 'deskripsi', 'harga', 'status', 'stok');
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menu_items', 'public');
        }
        MenuItem::create($data);
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
        return view('menu_items.edit', compact('menuItem', 'categories'));
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
            'status' => 'required|in:aktif,tidak aktif',
            'stok' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('nama', 'kategori_id', 'deskripsi', 'harga', 'status', 'stok');
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menuItem->gambar) {
                Storage::disk('public')->delete($menuItem->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('menu_items', 'public');
        }
        $menuItem->update($data);
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
}
