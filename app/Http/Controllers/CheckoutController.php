<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = $subtotal > 999 ? 0 : 99;
        $total = $subtotal + $shipping;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:191',
            'shipping_email' => 'required|email|max:191',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zipcode' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,upi,card',
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = $subtotal > 999 ? 0 : 99;
        $discount = 0;

        // Apply coupon
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
                $coupon->increment('used_count');
            }
        }

        $tax = round(($subtotal - $discount) * 0.18, 2); // 18% GST
        $total = $subtotal + $shipping - $discount + $tax;

        DB::transaction(function () use ($request, $cartItems, $subtotal, $shipping, $discount, $tax, $total) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
                'payment_method' => $request->payment_method,
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zipcode' => $request->shipping_zipcode,
                'shipping_country' => 'India',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'total' => $item->product->price * $item->quantity,
                ]);

                // Decrease stock
                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sales_count', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            session(['last_order_id' => $order->id]);
        });

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        $orderId = session('last_order_id');
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with('items.product')->findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
}
