@extends('admin.layouts.app')
@section('page_title', 'Discounts')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <p style="color:#6d7175;">Manage discount codes and automatic discounts</p>
    <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Create discount</a>
</div>
<div class="admin-card">
    <h3><i class="fas fa-percent"></i> Discount Codes</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $coupons = \App\Models\Coupon::all(); @endphp
            @forelse($coupons as $coupon)
                <tr>
                    <td><strong>{{ $coupon->code }}</strong></td>
                    <td>{{ ucfirst($coupon->type) }}</td>
                    <td>{{ $coupon->type === 'percentage' ? $coupon->value.'%' : '₹'.$coupon->value }}</td>
                    <td>₹{{ number_format($coupon->min_order_amount) }}</td>
                    <td><span class="badge badge-{{ $coupon->is_active ? 'delivered' : 'cancelled' }}">{{ $coupon->is_active ? 'Active' : 'Inactive' }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;padding:40px;color:#6d7175;">No discount codes yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
