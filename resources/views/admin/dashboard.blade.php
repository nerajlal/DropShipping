@extends('admin.layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e3f1df;color:#008060;"><i class="fas fa-rupee-sign"></i></div>
        <h3>₹{{ number_format($stats['total_revenue'], 0) }}</h3>
        <p>Total Revenue</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e3e8ff;color:#3d5afe;"><i class="fas fa-shopping-cart"></i></div>
        <h3>{{ $stats['total_orders'] }}</h3>
        <p>Total Orders</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e8f4fd;color:#2c6ecb;"><i class="fas fa-box"></i></div>
        <h3>{{ $stats['total_products'] }}</h3>
        <p>Products</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff8e6;color:#b98900;"><i class="fas fa-users"></i></div>
        <h3>{{ $stats['total_customers'] }}</h3>
        <p>Customers</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff4f4;color:#d72c0d;"><i class="fas fa-clock"></i></div>
        <h3>{{ $stats['pending_orders'] }}</h3>
        <p>Pending Orders</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e3f1df;color:#008060;"><i class="fas fa-calendar-day"></i></div>
        <h3>{{ $stats['today_orders'] }}</h3>
        <p>Today's Orders</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div class="admin-card">
        <h3><i class="fas fa-clock" style="color:#5c5f62;"></i> Recent Orders</h3>
        @if($recentOrders->count())
            <table class="data-table" style="border:none;box-shadow:none;border-radius:0;">
                <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($order->total, 0) }}</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#6d7175;padding:20px;">No orders yet.</p>
        @endif
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-fire" style="color:#d72c0d;"></i> Top Products</h3>
        <div style="padding:0 20px 20px;">
            @foreach($topProducts as $product)
                <div style="display:flex;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid #e1e3e5;">
                    <img src="{{ $product->image }}" style="width:40px;height:40px;border-radius:6px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/40/f6f6f7/6d7175?text=TD'">
                    <div style="flex:1;"><p style="font-weight:500;font-size:14px;">{{ $product->name }}</p><small style="color:#6d7175;">{{ $product->sales_count }} sales</small></div>
                    <span style="font-weight:600;color:#008060;">₹{{ number_format($product->price, 0) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
