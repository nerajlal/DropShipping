@extends('admin.layouts.app')
@section('page_title', 'Products')

@section('content')
<div class="toolbar">
    <form action="{{ route('admin.products.index') }}" method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap;">
        <input type="text" name="search" class="form-control search-input" placeholder="Search products..." value="{{ request('search') }}">
        <select name="category" class="form-control" style="width:200px;" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
        </select>
        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
</div>

<table class="data-table">
    <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td><img src="{{ $product->image }}" style="width:45px;height:45px;border-radius:8px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/45/1a1a2e/6c5ce7?text=TD'"></td>
                <td><strong>{{ $product->name }}</strong><br><small style="color:var(--muted);">SKU: {{ $product->sku }}</small></td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>₹{{ number_format($product->price, 0) }} @if($product->compare_price)<br><small style="color:var(--muted);text-decoration:line-through;">₹{{ number_format($product->compare_price, 0) }}</small>@endif</td>
                <td>{{ $product->stock }}</td>
                <td>@if($product->is_active)<span class="badge badge-delivered">Active</span>@else<span class="badge badge-cancelled">Inactive</span>@endif</td>
                <td style="display:flex;gap:6px;">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?');">@csrf @method('DELETE')<button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination" style="margin-top:20px;">{{ $products->appends(request()->query())->links('partials.pagination') }}</div>
@endsection
