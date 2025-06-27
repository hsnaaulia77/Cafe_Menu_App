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
        ]);
        Promotion::create($request->all());
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
} 