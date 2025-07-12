<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::orderBy('number')->paginate(10);
        return view('tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|integer|unique:tables,number',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,digunakan,tidak tersedia',
            'lokasi' => 'nullable|string|max:255',
        ]);
        Table::create($request->only('number', 'kapasitas', 'status', 'lokasi'));
        return redirect()->route('tables.index')->with('success', 'Meja berhasil ditambahkan!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|integer|unique:tables,number,'.$id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,digunakan,tidak tersedia',
            'lokasi' => 'nullable|string|max:255',
        ]);
        $table = Table::findOrFail($id);
        $table->update($request->only('number', 'kapasitas', 'status', 'lokasi'));
        return redirect()->route('tables.index')->with('success', 'Meja berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Meja berhasil dihapus!');
    }
}
