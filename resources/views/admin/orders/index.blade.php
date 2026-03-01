@extends('admin.layouts.app')
@section('page_title', 'Orders')

@section('content')
<div class="toolbar">
    <form action="{{ route('admin.orders.index') }}" method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap;">
        <input type="text" name="search" class="form-control search-input" placeholder="Search order number..." value="{{ request('search') }}">
        <select name="status" class="form-control" style="width:180px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<table class="data-table">
    <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->user->name ?? 'N/A' }}<br><small style="color:var(--muted);">{{ $order->user->email ?? '' }}</small></td>
                <td style="font-weight:600;">₹{{ number_format($order->total, 0) }}</td>
                <td><span class="badge badge-{{ $order->payment_status === 'paid' ? 'delivered' : 'pending' }}">{{ ucfirst($order->payment_status) }}</span></td>
                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a></td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">No orders found.</td></tr>
        @endforelse
    </tbody>
</table>
<div class="pagination" style="margin-top:20px;">{{ $orders->appends(request()->query())->links('partials.pagination') }}</div>
@endsection
