<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $bestSellers = Product::where('is_active', true)
            ->with('category')
            ->orderByDesc('sales_count')
            ->take(4)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'bestSellers'));
    }
}
