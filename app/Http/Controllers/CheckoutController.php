<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $rules = [
            'shipping_type'  => 'required|in:pickup,local,outside',
            'shipping_name'  => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:transfer,cod,store',
            'notes'          => 'nullable|string|max:500',
        ];

        // Alamat hanya wajib kalau bukan ambil di toko
        if ($request->shipping_type !== 'pickup') {
            $rules['shipping_address']     = 'required|string';
            $rules['shipping_city']        = 'required|string|max:100';
            $rules['shipping_province']    = 'required|string|max:100';
            $rules['shipping_postal_code'] = 'required|string|max:10';
        }

        $request->validate($rules);

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        try {
        $order = DB::transaction(function () use ($request, $cart) {
            // Lock product rows to prevent race condition on stock
            $productIds = $cart->items->pluck('product_id')->all();
            \App\Models\Product::whereIn('id', $productIds)->lockForUpdate()->get();

            // Re-check stock inside the lock
            foreach ($cart->items as $item) {
                $item->product->refresh();
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception('Stok produk "' . $item->product->name . '" tidak mencukupi.');
                }
            }

            $subtotal = $cart->items->sum(fn($i) => $i->price * $i->quantity);

            $shippingCost = match ($request->shipping_type) {
                'pickup'  => 0,
                'local'   => 15000,
                'outside' => 0, // dikonfirmasi admin via WA
                default   => 0,
            };

            $total = $subtotal + $shippingCost;

            $order = Order::create([
                'order_number'        => 'MLG-' . strtoupper(Str::random(8)),
                'user_id'             => auth()->id(),
                'status'              => 'pending',
                'subtotal'            => $subtotal,
                'shipping_cost'       => $shippingCost,
                'total'               => $total,
                'payment_method'      => $request->payment_method,
                'payment_status'      => 'unpaid',
                'shipping_type'       => $request->shipping_type,
                'shipping_name'       => $request->shipping_name,
                'shipping_phone'      => $request->shipping_phone,
                'shipping_address'    => $request->shipping_type === 'pickup' ? 'Ambil di Toko' : $request->shipping_address,
                'shipping_city'       => $request->shipping_type === 'pickup' ? 'Malang' : $request->shipping_city,
                'shipping_province'   => $request->shipping_type === 'pickup' ? 'Jawa Timur' : $request->shipping_province,
                'shipping_postal_code' => $request->shipping_type === 'pickup' ? '-' : $request->shipping_postal_code,
                'notes'               => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_thumbnail' => $item->product->thumbnail,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            return $order;
        });
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        // Kirim notifikasi ke customer dan semua admin
        $order->load('items', 'user');
        $order->user->notify(new OrderPlacedNotification($order));
        User::where('role', 'admin')->each(fn($admin) => $admin->notify(new OrderPlacedNotification($order)));

        return redirect()->route('orders.show', $order->order_number)->with('success', 'Pesanan berhasil dibuat!');
    }
}
