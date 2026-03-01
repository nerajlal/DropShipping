@extends('layouts.app')
@section('title', ($currentCategory ? $currentCategory->name : 'All Products') . ' - TechDrop')

@section('content')
<div class="container">
    <div class="products-layout">
        {{-- Sidebar --}}
        <aside class="filter-sidebar">
            <div class="filter-card">
                <h3>Categories</h3>
                <ul class="filter-list">
                    <li><a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}">All Products</a></li>
                    @foreach($categories as $cat)
                        <li><a href="{{ route('products.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" class="{{ request('category') == $cat->slug ? 'active' : '' }}">{{ $cat->name }} <span class="count">{{ $cat->products_count }}</span></a></li>
                    @endforeach
                </ul>
            </div>
            <div class="filter-card">
                <h3>Sort By</h3>
                <form action="{{ route('products.index') }}" method="GET">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    </select>
                </form>
            </div>
            <div class="filter-card">
                <h3>Brands</h3>
                <ul class="filter-list">
                    @foreach($brands as $brand)
                        <li><a href="{{ route('products.index', array_merge(request()->query(), ['brand' => $brand])) }}" class="{{ request('brand') == $brand ? 'active' : '' }}">{{ $brand }}</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Products --}}
        <div>
            <div class="products-header">
                <h2>{{ $currentCategory ? $currentCategory->name : (request('search') ? 'Search: "'.request('search').'"' : 'All Products') }}</h2>
                <span class="results-count">{{ $products->total() }} products found</span>
            </div>
            @if($products->count())
                <div class="products-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="pagination-wrapper">{{ $products->links('partials.pagination') }}</div>
            @else
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>No products found</h3>
                    <p>Try adjusting your filters or search terms</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
