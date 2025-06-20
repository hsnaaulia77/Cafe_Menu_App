<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        if (auth()->check() && auth()->user()->is_admin) {
            // Untuk admin
            return view('menus.index', compact('menus'));
        } else {
            // Untuk user biasa
            return view('menus.user_index', compact('menus'));
        }
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
            'kategori' => 'required|in:Makanan,Minuman,Camilan',
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
            'kategori' => 'required|in:Makanan,Minuman,Camilan',
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