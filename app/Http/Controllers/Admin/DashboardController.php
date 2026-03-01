<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::orderByDesc('sales_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
