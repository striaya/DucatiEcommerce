<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $items = Cart::where('user_id', Auth::id())
                        ->with('product.category')
                        ->get();

        $grandTotal = $items->sum(fn($item) => $item->quantity * $item->product->price);
        return view('cart.index', compact('items', 'grandTotal'));
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,products_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', "Stok tidak cukup. Tersisa: {$product->stock}.");
        }

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity, 'added_at' => now()]
        );

        return back()->with('success', "{$product->name} ditambahkan di keranjang.");
    }

    public function update(Request $request, int $cartId) {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = Cart::whereRaw('user_id', Auth::id())->findOrFail($cartId);

        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', "Stok tidak cukup. Tersis: {$cart->product->stock}.");
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('error', "Stok tidak cukup. Tersisa: {$cart->product->stock}.");
    }

    public function clear() {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
