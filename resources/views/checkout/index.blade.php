@extends('layouts.app')
@section('title', 'Checkout - TechDrop')

@section('content')
<div class="container checkout-section">
    <h2 class="section-title" style="text-align:left;margin-bottom:32px;"><i class="fas fa-lock" style="color:var(--accent-light);"></i> Checkout</h2>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-grid">
            <div>
                {{-- Shipping --}}
                <div class="form-card" style="margin-bottom:24px;">
                    <h3><i class="fas fa-truck"></i> Shipping Details</h3>
                    @if($errors->any())
                        <div class="errors-box"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif
                    <div class="form-row">
                        <div class="form-group"><label>Full Name *</label><input type="text" name="shipping_name" class="form-control" value="{{ old('shipping_name', auth()->user()->name) }}" required></div>
                        <div class="form-group"><label>Email *</label><input type="email" name="shipping_email" class="form-control" value="{{ old('shipping_email', auth()->user()->email) }}" required></div>
                    </div>
                    <div class="form-group"><label>Phone *</label><input type="text" name="shipping_phone" class="form-control" value="{{ old('shipping_phone') }}" required></div>
                    <div class="form-group"><label>Address *</label><textarea name="shipping_address" class="form-control" rows="2" required>{{ old('shipping_address') }}</textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>City *</label><input type="text" name="shipping_city" class="form-control" value="{{ old('shipping_city') }}" required></div>
                        <div class="form-group"><label>State *</label><input type="text" name="shipping_state" class="form-control" value="{{ old('shipping_state') }}" required></div>
                    </div>
                    <div class="form-group"><label>PIN Code *</label><input type="text" name="shipping_zipcode" class="form-control" value="{{ old('shipping_zipcode') }}" required></div>
                </div>

                {{-- Payment --}}
                <div class="form-card">
                    <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                    <div class="payment-options">
                        <label class="payment-option selected">
                            <input type="radio" name="payment_method" value="cod" checked> <i class="fas fa-money-bill-wave"></i>
                            <div><strong>Cash on Delivery</strong><br><small style="color:var(--text-muted);">Pay when your order arrives</small></div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="upi"> <i class="fas fa-mobile-alt"></i>
                            <div><strong>UPI Payment</strong><br><small style="color:var(--text-muted);">Google Pay, PhonePe, Paytm</small></div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card"> <i class="fas fa-credit-card"></i>
                            <div><strong>Credit/Debit Card</strong><br><small style="color:var(--text-muted);">Visa, Mastercard, Rupay</small></div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="cart-summary">
                <h3>Order Summary</h3>
                @foreach($cartItems as $item)
                    <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);">
                        <img src="{{ $item->product->image }}" style="width:50px;height:50px;border-radius:8px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/50/1a1a2e/6c5ce7?text=TD'">
                        <div style="flex:1;"><p style="font-size:0.85rem;font-weight:500;">{{ $item->product->name }}</p><small style="color:var(--text-muted);">Qty: {{ $item->quantity }}</small></div>
                        <span style="font-weight:600;">₹{{ number_format($item->product->price * $item->quantity, 0) }}</span>
                    </div>
                @endforeach
                <div class="summary-row" style="margin-top:12px;"><span>Subtotal</span><span>₹{{ number_format($subtotal, 0) }}</span></div>
                <div class="summary-row"><span>Shipping</span><span class="{{ $shipping == 0 ? 'free-shipping' : '' }}">{{ $shipping == 0 ? 'FREE' : '₹'.$shipping }}</span></div>
                <div class="summary-row"><span>GST (18%)</span><span>₹{{ number_format($subtotal * 0.18, 0) }}</span></div>
                <div class="summary-row total"><span>Total</span><span>₹{{ number_format($total + ($subtotal * 0.18), 0) }}</span></div>
                <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:20px;"><i class="fas fa-check-circle"></i> Place Order</button>
            </div>
        </div>
    </form>
</div>
@endsection
