@extends('layouts.app')
@section('title', 'My Account - TechDrop')

@section('content')
<div class="container account-section">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;">
        <div>
            <h2 class="section-title" style="text-align:left;margin-bottom:4px;">My Account</h2>
            <p style="color:var(--text-muted);">Welcome back, {{ $user->name }}!</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Logout</button></form>
    </div>

    @if(auth()->user()->email === 'admin@techdrop.com')
        <div style="margin-bottom:24px;"><a href="{{ route('admin.dashboard') }}" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></div>
    @endif

    <div class="form-card">
        <h3 style="margin-bottom:20px;"><i class="fas fa-shopping-bag" style="color:var(--accent-light);"></i> Order History</h3>
        @if($orders->count())
            <div style="overflow-x:auto;">
                <table class="orders-table">
                    <thead><tr><th>Order #</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td style="font-weight:600;">{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ $order->items->count() }} items</td>
                                <td style="font-weight:600;">₹{{ number_format($order->total, 0) }}</td>
                                <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td><a href="{{ route('account.order', $order->id) }}" class="btn btn-secondary btn-sm">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper" style="margin-top:20px;">{{ $orders->links('partials.pagination') }}</div>
        @else
            <div class="empty-state" style="padding:32px;"><i class="fas fa-box-open"></i><h3>No orders yet</h3><p>Start shopping to see your orders here!</p><a href="{{ route('products.index') }}" class="btn btn-primary">Shop Now</a></div>
        @endif
    </div>
</div>
@endsection
