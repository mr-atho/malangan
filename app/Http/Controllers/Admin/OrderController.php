<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdatedNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $orders = $query->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);

        $updates = ['status' => $request->status];

        if ($request->status === 'shipped') {
            $updates['shipped_at'] = now();
        } elseif ($request->status === 'delivered') {
            $updates['delivered_at'] = now();
            $updates['payment_status'] = 'paid';
            $updates['paid_at'] = now();
        }

        $oldStatus = $order->status;
        $order->update($updates);

        if ($order->user) {
            $order->user->notify(new OrderStatusUpdatedNotification($order, $oldStatus));
        }

        return back()->with('success', 'Status pesanan diperbarui!');
    }

    public function updateShipping(Request $request, Order $order)
    {
        $request->validate([
            'shipping_cost'   => 'nullable|numeric|min:0',
            'courier'         => 'nullable|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $updates = [];

        if ($request->filled('shipping_cost')) {
            $updates['shipping_cost'] = $request->shipping_cost;
            $updates['total'] = $order->subtotal + $request->shipping_cost;
        }

        if ($request->filled('courier')) {
            $updates['courier'] = $request->courier;
        }

        if ($request->filled('tracking_number')) {
            $updates['tracking_number'] = $request->tracking_number;
        }

        $order->update($updates);

        return back()->with('success', 'Informasi pengiriman diperbarui!');
    }
}
