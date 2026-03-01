@extends('layouts.app')
@section('title', 'TechDrop - Premium Tech Gadgets Store')

@section('content')
{{-- Hero Section --}}
<section class="hero">
    <div class="hero-bg">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>
        <div class="hero-grid-pattern"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge"><span class="badge-pulse"></span> #1 Tech Gadget Store in India</div>
                <h1 class="hero-title">Premium Tech<br><span class="hero-title-gradient">at Your Fingertips</span></h1>
                <p class="hero-subtitle">Curated collection of cutting-edge gadgets sourced directly from top manufacturers. Fast delivery, quality guaranteed.</p>
                <div class="hero-actions">
                    <a href="{{ route('products.index') }}" class="btn-hero-primary">
                        <span>Explore Products</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('products.index', ['sort' => 'popular']) }}" class="btn-hero-secondary">
                        <i class="fas fa-fire"></i>
                        <span>Trending Now</span>
                    </a>
                </div>
                <div class="hero-trust">
                    <div class="trust-item">
                        <div class="trust-avatars">
                            <div class="trust-avatar" style="background:#667eea;">N</div>
                            <div class="trust-avatar" style="background:#f093fb;">A</div>
                            <div class="trust-avatar" style="background:#4facfe;">R</div>
                            <div class="trust-avatar" style="background:#43e97b;">S</div>
                        </div>
                        <div class="trust-text">
                            <strong>10,000+</strong> happy customers
                        </div>
                    </div>
                    <div class="trust-rating">
                        <div class="stars-row">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <span>4.8/5 rating</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-product-showcase">
                    <div class="showcase-card showcase-main">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop" alt="Premium Headphones">
                        <div class="showcase-tag">Best Seller</div>
                    </div>
                    <div class="showcase-card showcase-float-1">
                        <img src="https://images.unsplash.com/photo-1546868871-af0de0ae72be?w=200&h=200&fit=crop" alt="Smartwatch">
                    </div>
                    <div class="showcase-card showcase-float-2">
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=200&h=200&fit=crop" alt="Earbuds">
                    </div>
                    <div class="showcase-stat-card">
                        <i class="fas fa-truck"></i>
                        <div><strong>Free Shipping</strong><span>Orders above ₹999</span></div>
                    </div>
                    <div class="showcase-stat-card showcase-stat-2">
                        <i class="fas fa-shield-alt"></i>
                        <div><strong>100% Genuine</strong><span>Quality Certified</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features Bar --}}
<section class="section" style="padding-top:0;padding-bottom:0;position:relative;z-index:2;margin-top:-40px;">
    <div class="container">
        <div class="features-bar">
            <div class="feature-item" data-animate="fade-up">
                <div class="feature-icon"><i class="fas fa-truck"></i></div>
                <div><h4>Fast Delivery</h4><p>3-7 business days</p></div>
            </div>
            <div class="feature-item" data-animate="fade-up" data-delay="100">
                <div class="feature-icon"><i class="fas fa-undo"></i></div>
                <div><h4>Easy Returns</h4><p>30-day return policy</p></div>
            </div>
            <div class="feature-item" data-animate="fade-up" data-delay="200">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <div><h4>Secure Payment</h4><p>SSL encrypted</p></div>
            </div>
            <div class="feature-item" data-animate="fade-up" data-delay="300">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <div><h4>24/7 Support</h4><p>Dedicated help</p></div>
            </div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="section">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">Shop by Category</h2>
            <p class="section-subtitle">Browse our curated collection of tech categories</p>
        </div>
        <div class="categories-grid">
            @foreach($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="category-card" data-animate="fade-up">
                    <div class="category-icon"><i class="{{ $cat->icon }}"></i></div>
                    <h3>{{ $cat->name }}</h3>
                    <span>{{ $cat->products_count }} Products</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">Featured Products</h2>
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
        <div class="deals-banner" data-animate="fade-up">
            <div class="deals-content">
                <span class="deals-tag">Limited Offer</span>
                <h2>Get 10% OFF Your First Order</h2>
                <p>Use code <strong>WELCOME10</strong> at checkout. Minimum order ₹999.</p>
                <a href="{{ route('products.index') }}" class="btn-hero-primary" style="display:inline-flex;">
                    <span>Shop Now</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="deals-visual">
                <div class="coupon-display">
                    <div class="coupon-code">WELCOME10</div>
                    <div class="coupon-value">10% OFF</div>
                </div>
                <div class="deals-features">
                    <div class="deal-feature"><i class="fas fa-check-circle"></i> Free shipping on ₹999+</div>
                    <div class="deal-feature"><i class="fas fa-check-circle"></i> No hidden charges</div>
                    <div class="deal-feature"><i class="fas fa-check-circle"></i> 30-day easy returns</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Latest Products --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">New Arrivals</h2>
            <p class="section-subtitle">The latest tech gadgets just for you</p>
        </div>
        <div class="products-grid">
            @foreach($latestProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div style="text-align:center;margin-top:40px;" data-animate="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">View All Products <i class="fas fa-arrow-right" style="margin-left:4px;"></i></a>
        </div>
    </div>
</section>
@endsection
