@extends('layouts.app')
@section('title', $product->name . ' - TechDrop')

@section('content')
<div class="container product-detail">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> / <a href="{{ route('products.index') }}">Products</a> / <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a> / <span>{{ $product->name }}</span>
    </div>

    <div class="product-detail-grid" style="margin-top:24px;">
        <div class="product-gallery">
            <div class="gallery-main">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/600x450/1a1a2e/6c5ce7?text=TechDrop'">
            </div>
        </div>

        <div class="product-detail-info">
            <div class="product-category" style="margin-bottom:8px;">{{ $product->category->name }}</div>
            <h1>{{ $product->name }}</h1>

            <div class="product-rating" style="margin:12px 0;">
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star" style="{{ $i > round($product->rating) ? 'opacity:0.3' : '' }}"></i>
                    @endfor
                </div>
                <span class="rating-count">{{ $product->rating }} ({{ $product->reviews_count }} reviews)</span>
                <span style="color:var(--text-muted);">|</span>
                <span style="color:var(--success);font-size:0.85rem;"><i class="fas fa-check-circle"></i> {{ $product->sales_count }} sold</span>
            </div>

            <div class="detail-price">
                <span class="current-price">{{ $product->formatted_price }}</span>
                @if($product->compare_price)
                    <span class="original-price" style="font-size:1.2rem;">{{ $product->formatted_compare_price }}</span>
                    <span class="product-badge badge-sale">-{{ $product->discount_percent }}% OFF</span>
                @endif
            </div>

            <div class="detail-meta">
                <div class="meta-item"><i class="fas fa-truck"></i> {{ $product->shipping_time ?? '3-7 days' }} delivery</div>
                <div class="meta-item"><i class="fas fa-box"></i> {{ $product->stock > 0 ? 'In Stock ('.$product->stock.')' : 'Out of Stock' }}</div>
                @if($product->brand)<div class="meta-item"><i class="fas fa-tag"></i> {{ $product->brand }}</div>@endif
            </div>

            <div class="detail-description">{!! $product->short_description !!}</div>

            <div class="quantity-selector">
                <span style="font-size:0.9rem;color:var(--text-secondary);">Quantity:</span>
                <button class="qty-btn" onclick="updateQty('decrease')">−</button>
                <input type="number" id="qtyInput" class="qty-input" value="1" min="1" max="10">
                <button class="qty-btn" onclick="updateQty('increase')">+</button>
            </div>

            <div class="detail-actions">
                <button class="btn btn-primary btn-lg add-to-cart-btn" data-product-id="{{ $product->id }}"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
                <a href="{{ route('cart.index') }}" class="btn btn-secondary btn-lg"><i class="fas fa-shopping-cart"></i> Go to Cart</a>
            </div>

            @if($product->specifications)
                <h3 style="margin-bottom:14px;font-family:var(--font-display);">Specifications</h3>
                <table class="specs-table">
                    @foreach($product->specifications as $key => $value)
                        <tr><td>{{ $key }}</td><td>{{ $value }}</td></tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    @if($product->description)
        <div class="section">
            <h3 class="section-title" style="text-align:left;font-size:1.4rem;">Product Description</h3>
            <div class="detail-description" style="margin-top:16px;">{!! $product->description !!}</div>
        </div>
    @endif

    @if($relatedProducts->count())
        <div class="section">
            <div class="section-header"><h2 class="section-title">Related <span class="gradient-text">Products</span></h2></div>
            <div class="products-grid">
                @foreach($relatedProducts as $rp)
                    @include('partials.product-card', ['product' => $rp])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
