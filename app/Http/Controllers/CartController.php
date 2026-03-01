<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = $subtotal > 999 ? 0 : 99;
        $total = $subtotal + $shipping;

        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->get('quantity', 1);

        $cartItem = Cart::where('product_id', $product->id)
            ->where(function ($q) {
                if (Auth::check()) {
                    $q->where('user_id', Auth::id());
                } else {
                    $q->where('session_id', session()->getId());
                }
            })->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : session()->getId(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:10']);

        $cartItem = Cart::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            $cartItems = $this->getCartItems();
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $shipping = $subtotal > 999 ? 0 : 99;

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 0),
                'shipping' => $shipping,
                'total' => number_format($subtotal + $shipping, 0),
                'item_total' => number_format($cartItem->product->price * $request->quantity, 0),
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, $id)
    {
        Cart::findOrFail($id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    private function getCartItems()
    {
        return Cart::with('product.category')
            ->where(function ($q) {
                if (Auth::check()) {
                    $q->where('user_id', Auth::id());
                } else {
                    $q->where('session_id', session()->getId());
                }
            })->get();
    }

    public function getCartCount()
    {
        return Cart::where(function ($q) {
            if (Auth::check()) {
                $q->where('user_id', Auth::id());
            } else {
                $q->where('session_id', session()->getId());
            }
        })->sum('quantity');
    }
}
