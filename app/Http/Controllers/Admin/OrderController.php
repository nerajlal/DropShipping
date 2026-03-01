<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number ?? $order->tracking_number,
            'tracking_url' => $request->tracking_url ?? $order->tracking_url,
        ]);

        if ($request->status === 'delivered') {
            $order->update(['payment_status' => 'paid']);
        }

        return redirect()->back()->with('success', 'Order status updated!');
    }
}
