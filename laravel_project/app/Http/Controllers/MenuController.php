<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter harga minimum
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }

        // Filter harga maksimum
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Sorting
        switch ($request->sort) {
            case 'nama_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama', 'desc');
                break;
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'kategori_asc':
                $query->orderBy('kategori', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination dengan query string
        $menus = $query->paginate(12)->withQueryString();

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.manage');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:Makanan,Minuman,Snack',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Tersedia,Tidak tersedia',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('menus', 'public');
        }

        Menu::create($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('menus.manage', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:Makanan,Minuman,Snack',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Tersedia,Tidak tersedia',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menu->gambar) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('menus', 'public');
        }

        $menu->update($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->gambar) {
            Storage::disk('public')->delete($menu->gambar);
        }
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}