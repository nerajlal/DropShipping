@extends('layouts.app')
@section('title', 'TechDrop - Premium Tech Gadgets Store')

@section('content')
{{-- Hero Section --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge"><i class="fas fa-bolt"></i> #1 Tech Gadget Store</div>
                <h1 class="hero-title">Next-Gen <span class="gradient-text">Tech Gadgets</span> at Unbeatable Prices</h1>
                <p class="hero-subtitle">Discover premium gadgets sourced directly from top manufacturers. Fast delivery, quality guaranteed, prices you'll love.</p>
                <div class="hero-actions">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-shopping-bag"></i> Shop Now</a>
                    <a href="{{ route('products.index', ['sort' => 'popular']) }}" class="btn btn-secondary btn-lg"><i class="fas fa-fire"></i> Trending</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat"><h3><span class="gradient-text">10K+</span></h3><p>Happy Customers</p></div>
                    <div class="hero-stat"><h3><span class="gradient-text">500+</span></h3><p>Products</p></div>
                    <div class="hero-stat"><h3><span class="gradient-text">50+</span></h3><p>Brands</p></div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image-wrapper">
                    <i class="fas fa-microchip"></i>
                    <div class="floating-card">
                        <i class="fas fa-truck"></i>
                        <div class="fc-text"><strong>Fast Delivery</strong>3-7 Business Days</div>
                    </div>
                    <div class="floating-card">
                        <i class="fas fa-shield-alt"></i>
                        <div class="fc-text"><strong>Quality Assured</strong>100% Genuine</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features Bar --}}
<section class="section" style="padding-top:20px;padding-bottom:0;">
    <div class="container">
        <div class="features-bar">
            <div class="feature-item"><div class="feature-icon"><i class="fas fa-truck"></i></div><div><h4>Fast Delivery</h4><p>3-7 business days</p></div></div>
            <div class="feature-item"><div class="feature-icon"><i class="fas fa-undo"></i></div><div><h4>Easy Returns</h4><p>30-day return policy</p></div></div>
            <div class="feature-item"><div class="feature-icon"><i class="fas fa-lock"></i></div><div><h4>Secure Payment</h4><p>SSL encrypted</p></div></div>
            <div class="feature-item"><div class="feature-icon"><i class="fas fa-headset"></i></div><div><h4>24/7 Support</h4><p>Dedicated help</p></div></div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Shop by <span class="gradient-text">Category</span></h2>
            <p class="section-subtitle">Browse our curated collection of tech categories</p>
        </div>
        <div class="categories-grid">
            @foreach($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="category-card">
                    <div class="category-icon"><i class="{{ $cat->icon }}"></i></div>
                    <h3>{{ $cat->name }}</h3>
                    <span>{{ $cat->products_count }} Products</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="section" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured <span class="gradient-text">Products</span></h2>
            <p class="section-subtitle">Hand-picked gadgets with the best quality and value</p>
        </div>
        <div class="products-grid">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

{{-- Deals Banner --}}
<section class="section">
    <div class="container">
        <div class="deals-banner">
            <h2>🔥 Use code <strong>WELCOME10</strong> for 10% OFF your first order!</h2>
            <p>Minimum order ₹999. Limited time offer.</p>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg" style="background:#fff;color:#333;border:none;"><i class="fas fa-arrow-right"></i> Shop Now</a>
        </div>
    </div>
</section>

{{-- Latest Products --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">New <span class="gradient-text">Arrivals</span></h2>
            <p class="section-subtitle">The latest tech gadgets just for you</p>
        </div>
        <div class="products-grid">
            @foreach($latestProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div style="text-align:center;margin-top:32px;">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">View All Products <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
@endsection
