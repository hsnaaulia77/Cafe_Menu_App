<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('menuItem')->orderBy('tanggal', 'desc')->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        $menuItems = MenuItem::all();
        return view('reviews.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'nullable|string|max:255',
            'menu_item_id' => 'required|exists:menu_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        Review::create($request->all());
        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan!');
    }

    public function edit(Review $review)
    {
        $menuItems = MenuItem::all();
        return view('reviews.edit', compact('review', 'menuItems'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'nama_customer' => 'nullable|string|max:255',
            'menu_item_id' => 'required|exists:menu_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        $review->update($request->all());
        return redirect()->route('reviews.index')->with('success', 'Review berhasil diupdate!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus!');
    }
} 