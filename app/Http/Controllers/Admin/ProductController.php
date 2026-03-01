<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'stock' => 'integer|min:0',
            'image' => 'nullable|string',
            'supplier_name' => 'nullable|string|max:191',
            'shipping_time' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sku'] = 'TD-' . strtoupper(Str::random(6));

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'stock' => 'integer|min:0',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'supplier_name' => 'nullable|string|max:191',
            'shipping_time' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
}
