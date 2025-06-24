<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriMenu;

class KategoriMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = KategoriMenu::orderBy('nama')->paginate(10);
        return view('admin.kategori_menu.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori_menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_menus,nama',
            'deskripsi' => 'nullable|string',
        ]);
        KategoriMenu::create($request->only('nama', 'deskripsi'));
        return redirect()->route('admin.kategori_menu.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori = KategoriMenu::findOrFail($id);
        return view('admin.kategori_menu.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriMenu::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_menus,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);
        $kategori->update($request->only('nama', 'deskripsi'));
        return redirect()->route('admin.kategori_menu.index')->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = KategoriMenu::findOrFail($id);
        $kategori->delete();
        return redirect()->route('admin.kategori_menu.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
