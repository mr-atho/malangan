<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart()
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(['user_id' => auth()->id()]);
        }
        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
    }

    public function index()
    {
        $cart = $this->getCart()->load('items.product');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:1']);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak cukup.');
        }

        $cart = $this->getCart();
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = $item->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Stok tidak cukup.');
            }
            $item->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorizeItem($item);
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($request->quantity > $item->product->stock) {
            return back()->with('error', 'Stok tidak cukup.');
        }

        $item->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function increment(CartItem $item)
    {
        $this->authorizeItem($item);
        if ($item->quantity < $item->product->stock) {
            $item->increment('quantity');
        } else {
            return back()->with('error', 'Stok tidak cukup.');
        }
        return back();
    }

    public function decrement(CartItem $item)
    {
        $this->authorizeItem($item);
        if ($item->quantity > 1) {
            $item->decrement('quantity');
        }
        return back();
    }

    public function remove(CartItem $item)
    {
        $this->authorizeItem($item);
        $item->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    private function authorizeItem(CartItem $item): void
    {
        $cart = $this->getCart();
        abort_if($item->cart_id !== $cart->id, 403);
    }

    public function count()
    {
        $cart = $this->getCart()->load('items');
        return response()->json(['count' => $cart->total_items]);
    }
}
