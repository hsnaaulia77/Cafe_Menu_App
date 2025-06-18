<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$request->menu_id])) {
            $cart[$request->menu_id]['quantity']++;
        } else {
            $cart[$request->menu_id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu added to cart successfully!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Menu removed from cart!');
    }
}
