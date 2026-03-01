@extends('layouts.app')
@section('title', 'Shopping Cart - TechDrop')

@section('content')
<div class="container cart-section">
    <h2 class="section-title" style="text-align:left;margin-bottom:32px;"><i class="fas fa-shopping-bag" style="color:var(--accent-light);"></i> Shopping Cart</h2>

    @if($cartItems->count())
        <div class="cart-grid">
            <div class="cart-items">
                @foreach($cartItems as $item)
                    <div class="cart-item" id="cart-item-{{ $item->id }}">
                        <div class="cart-item-image">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" onerror="this.src='https://via.placeholder.com/120/1a1a2e/6c5ce7?text=TD'">
                        </div>
                        <div class="cart-item-info">
                            <h3><a href="{{ route('products.show', $item->product->slug) }}" style="color:var(--text-primary);">{{ $item->product->name }}</a></h3>
                            <p class="category">{{ $item->product->category->name ?? '' }}</p>
                            <div class="cart-item-price" id="item-total-{{ $item->id }}">₹{{ number_format($item->product->price * $item->quantity, 0) }}</div>
                            <div class="cart-item-actions">
                                <button class="qty-btn" onclick="updateCartItem({{ $item->id }}, {{ max(1, $item->quantity - 1) }})">−</button>
                                <span style="padding:0 10px;font-weight:600;">{{ $item->quantity }}</span>
                                <button class="qty-btn" onclick="updateCartItem({{ $item->id }}, {{ min(10, $item->quantity + 1) }})">+</button>
                                <button class="btn btn-danger btn-sm" style="margin-left:auto;" onclick="removeCartItem({{ $item->id }})"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row"><span>Subtotal</span><span id="cart-subtotal">₹{{ number_format($subtotal, 0) }}</span></div>
                <div class="summary-row"><span>Shipping</span><span id="cart-shipping" class="{{ $shipping == 0 ? 'free-shipping' : '' }}">{{ $shipping == 0 ? 'FREE' : '₹'.$shipping }}</span></div>
                @if($subtotal < 999)<p style="font-size:0.8rem;color:var(--accent-light);margin-top:4px;">Free shipping on orders above ₹999</p>@endif
                <div class="summary-row total"><span>Total</span><span id="cart-total">₹{{ number_format($total, 0) }}</span></div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block btn-lg" style="margin-top:20px;"><i class="fas fa-lock"></i> Proceed to Checkout</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-block" style="margin-top:10px;"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-shopping-bag"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any products yet.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-shopping-bag"></i> Start Shopping</a>
        </div>
    @endif
</div>
@endsection
