<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('tanggal_mulai', 'desc')->paginate(10);
        return view('promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kode_voucher' => 'nullable|string|max:50',
            'diskon_persen' => 'nullable|integer|min:0|max:100',
            'potongan_harga' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'menu_berlaku_manual' => 'required|string',
        ]);
        $promotion = Promotion::create($request->all());
        // Simpan nama menu berlaku secara manual (jika ingin disimpan di kolom khusus, tambahkan di model/migrasi)
        // Atau, jika ingin tetap relasi, bisa parsing nama ke id di sini
        return redirect()->route('promotions.index')->with('success', 'Promosi berhasil ditambahkan!');
    }

    public function edit(Promotion $promotion)
    {
        return view('promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kode_voucher' => 'nullable|string|max:50',
            'diskon_persen' => 'nullable|integer|min:0|max:100',
            'potongan_harga' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        $promotion->update($request->all());
        return redirect()->route('promotions.index')->with('success', 'Promosi berhasil diupdate!');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'Promosi berhasil dihapus!');
    }

    public function editMenus($id)
    {
        $promotion = \App\Models\Promotion::with('menuItems')->findOrFail($id);
        $allMenus = \App\Models\MenuItem::all();
        return view('promotions.edit_menus', compact('promotion', 'allMenus'));
    }

    public function updateMenus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'menu_berlaku_manual' => 'required|string',
        ], [
            'menu_berlaku_manual.required' => 'Masukkan nama menu yang berlaku.',
        ]);
        $promotion = \App\Models\Promotion::findOrFail($id);
        // Simpan nama menu berlaku secara manual (jika ingin disimpan di kolom khusus, tambahkan di model/migrasi)
        // Atau, jika ingin tetap relasi, bisa parsing nama ke id di sini
        $promotion->update(['menu_berlaku_manual' => $request->input('menu_berlaku_manual')]);
        return redirect()->route('promotions.index')->with('success', 'Menu promosi berhasil diupdate!');
    }
} 