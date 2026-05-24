<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('stock', 'asc');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $filter = $request->get('filter', 'all');
        match ($filter) {
            'empty'  => $query->where('stock', 0),
            'low'    => $query->where('stock', '>', 0)->where('stock', '<=', 5),
            'safe'   => $query->where('stock', '>', 5),
            default  => null,
        };

        $products = $query->paginate(30)->withQueryString();

        $summary = [
            'empty' => Product::where('stock', 0)->count(),
            'low'   => Product::where('stock', '>', 0)->where('stock', '<=', 5)->count(),
            'safe'  => Product::where('stock', '>', 5)->count(),
        ];

        return view('admin.stock.index', compact('products', 'summary', 'filter'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update(['stock' => $request->stock]);

        return back()->with('success', "Stok \"$product->name\" diperbarui menjadi $request->stock.");
    }
}
