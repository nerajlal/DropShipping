<div class="product-card" data-animate="fade-up">
    <div class="product-image">
        <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy" onerror="this.src='https://via.placeholder.com/400x300/f0f0f5/6366f1?text=TechDrop'">
        @if($product->discount_percent)
            <span class="product-badge badge-sale">-{{ $product->discount_percent }}%</span>
        @endif
        <div class="product-overlay">
            <a href="{{ route('products.show', $product->slug) }}" class="overlay-btn"><i class="fas fa-eye"></i> Quick View</a>
        </div>
    </div>
    <div class="product-info">
        <div class="product-category">{{ $product->category->name ?? '' }}</div>
        <h3 class="product-name"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
        <div class="product-rating">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= round($product->rating) ? '' : ($i - 0.5 <= $product->rating ? '-half-alt' : '') }}" style="{{ $i > round($product->rating) ? 'opacity:0.3' : '' }}"></i>
                @endfor
            </div>
            <span class="rating-count">({{ $product->reviews_count }})</span>
        </div>
        <div class="product-price">
            <span class="current-price">{{ $product->formatted_price }}</span>
            @if($product->compare_price)
                <span class="original-price">{{ $product->formatted_compare_price }}</span>
                <span class="discount-tag">{{ $product->discount_percent }}% OFF</span>
            @endif
        </div>
        <div class="product-footer">
            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> View</a>
            <button class="btn btn-primary btn-sm add-to-cart-btn" data-product-id="{{ $product->id }}"><i class="fas fa-shopping-bag"></i> Add</button>
        </div>
    </div>
</div>
