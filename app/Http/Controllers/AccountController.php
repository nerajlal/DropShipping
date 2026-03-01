<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('account.index', compact('user', 'orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);

        return view('account.order-detail', compact('order'));
    }
}
