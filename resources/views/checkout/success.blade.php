@extends('layouts.app')
@section('title', 'Order Confirmed! - TechDrop')

@section('content')
<div class="success-section">
    <div class="success-card">
        <div class="success-icon"><i class="fas fa-check"></i></div>
        <h2>Order Placed Successfully! 🎉</h2>
        <p>Your order <strong>{{ $order->order_number }}</strong> has been confirmed.</p>
        <p style="color:var(--text-muted);font-size:0.9rem;">We'll send you tracking updates via email at <strong>{{ $order->shipping_email }}</strong></p>

        <div style="background:var(--bg-secondary);border-radius:var(--radius);padding:20px;margin:24px 0;text-align:left;">
            <div class="summary-row"><span>Order Total</span><span style="font-weight:700;font-size:1.2rem;">₹{{ number_format($order->total, 0) }}</span></div>
            <div class="summary-row"><span>Payment</span><span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></div>
            <div class="summary-row"><span>Status</span><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
            <div class="summary-row"><span>Items</span><span>{{ $order->items->sum('quantity') }} products</span></div>
        </div>

        <div style="display:flex;gap:12px;justify-content:center;">
            <a href="{{ route('account.order', $order->id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> View Order</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-shopping-bag"></i> Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
