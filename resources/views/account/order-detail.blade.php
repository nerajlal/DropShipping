@extends('layouts.app')
@section('title', 'Order ' . $order->order_number . ' - TechDrop')

@section('content')
<div class="container account-section">
    <div class="breadcrumb" style="margin-bottom:24px;">
        <a href="{{ route('account.index') }}">My Account</a> / <span>Order {{ $order->order_number }}</span>
    </div>

    <div class="checkout-grid">
        <div>
            <div class="form-card" style="margin-bottom:20px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h3>Order {{ $order->order_number }}</h3>
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="summary-row"><span>Date</span><span>{{ $order->created_at->format('d M Y, h:i A') }}</span></div>
                <div class="summary-row"><span>Payment</span><span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></div>
                @if($order->tracking_number)
                    <div class="summary-row"><span>Tracking</span><span><a href="{{ $order->tracking_url ?? '#' }}">{{ $order->tracking_number }}</a></span></div>
                @endif
            </div>

            <div class="form-card">
                <h3 style="margin-bottom:16px;">Items</h3>
                @foreach($order->items as $item)
                    <div style="display:flex;gap:14px;padding:12px 0;border-bottom:1px solid var(--border);">
                        <img src="{{ $item->product->image ?? '' }}" style="width:60px;height:60px;border-radius:8px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/60/1a1a2e/6c5ce7?text=TD'">
                        <div style="flex:1;"><p style="font-weight:500;">{{ $item->product_name }}</p><small style="color:var(--text-muted);">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 0) }}</small></div>
                        <span style="font-weight:600;">₹{{ number_format($item->total, 0) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="cart-summary">
                <h3>Summary</h3>
                <div class="summary-row"><span>Subtotal</span><span>₹{{ number_format($order->subtotal, 0) }}</span></div>
                <div class="summary-row"><span>Shipping</span><span>{{ $order->shipping_cost == 0 ? 'FREE' : '₹'.number_format($order->shipping_cost, 0) }}</span></div>
                <div class="summary-row"><span>Tax</span><span>₹{{ number_format($order->tax, 0) }}</span></div>
                @if($order->discount > 0)<div class="summary-row"><span>Discount</span><span style="color:var(--success);">-₹{{ number_format($order->discount, 0) }}</span></div>@endif
                <div class="summary-row total"><span>Total</span><span>₹{{ number_format($order->total, 0) }}</span></div>
            </div>

            <div class="form-card" style="margin-top:20px;">
                <h3 style="margin-bottom:12px;">Shipping To</h3>
                <p style="font-size:0.9rem;color:var(--text-secondary);line-height:1.8;">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zipcode }}<br>
                    📞 {{ $order->shipping_phone }}<br>
                    ✉ {{ $order->shipping_email }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
