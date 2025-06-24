<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $menus = Menu::where('status', 'Tersedia')->get();
        return view('admin.promos.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:diskon_persen,diskon_nominal,voucher,bundle',
            'nilai' => 'required|numeric|min:0',
            'kode_kupon' => 'nullable|string|unique:promos,kode_kupon',
            'minimum_pembelian' => 'nullable|numeric|min:0',
            'maksimal_penggunaan' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'menu_bundle' => 'nullable|array',
        ]);

        $data = $request->all();
        
        // Generate kode kupon otomatis jika jenis voucher dan kode tidak diisi
        if ($request->jenis === 'voucher' && empty($request->kode_kupon)) {
            $data['kode_kupon'] = 'VOUCHER' . strtoupper(uniqid());
        }

        Promo::create($data);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo): View
    {
        return view('admin.promos.show', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo): View
    {
        $menus = Menu::where('status', 'Tersedia')->get();
        return view('admin.promos.edit', compact('promo', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:diskon_persen,diskon_nominal,voucher,bundle',
            'nilai' => 'required|numeric|min:0',
            'kode_kupon' => 'nullable|string|unique:promos,kode_kupon,' . $promo->id,
            'minimum_pembelian' => 'nullable|numeric|min:0',
            'maksimal_penggunaan' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'menu_bundle' => 'nullable|array',
        ]);

        $promo->update($request->all());

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo): RedirectResponse
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dihapus!');
    }
}
