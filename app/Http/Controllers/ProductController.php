<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // Category filter
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low': $query->orderBy('price', 'asc'); break;
            case 'price_high': $query->orderBy('price', 'desc'); break;
            case 'popular': $query->orderByDesc('sales_count'); break;
            case 'rating': $query->orderByDesc('rating'); break;
            default: $query->latest(); break;
        }

        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();
        $brands = Product::where('is_active', true)->distinct()->pluck('brand')->filter();

        $currentCategory = $request->filled('category')
            ? Category::where('slug', $request->category)->first()
            : null;

        return view('products.index', compact('products', 'categories', 'brands', 'currentCategory'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'reviews.user'])
            ->firstOrFail();

        $product->increment('views');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
