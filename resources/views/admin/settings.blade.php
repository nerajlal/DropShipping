@extends('admin.layouts.app')
@section('page_title', 'Settings')
@section('content')
<div class="admin-card">
    <h3><i class="fas fa-store"></i> Store Details</h3>
    <div style="padding:20px;">
        <div class="form-group">
            <label>Store Name</label>
            <input type="text" class="form-control" value="TechDrop" readonly>
        </div>
        <div class="form-group">
            <label>Store Email</label>
            <input type="text" class="form-control" value="admin@techdrop.com" readonly>
        </div>
        <div class="form-group">
            <label>Currency</label>
            <input type="text" class="form-control" value="INR (₹)" readonly>
        </div>
    </div>
</div>
<div class="admin-card">
    <h3><i class="fas fa-truck"></i> Shipping</h3>
    <div style="padding:20px;">
        <div class="form-group">
            <label>Free Shipping Threshold</label>
            <input type="text" class="form-control" value="₹999" readonly>
        </div>
        <div class="form-group">
            <label>Shipping Provider</label>
            <input type="text" class="form-control" value="CJ Dropshipping" readonly>
        </div>
    </div>
</div>
<div class="admin-card">
    <h3><i class="fas fa-credit-card"></i> Payments</h3>
    <div style="padding:20px;">
        <p style="color:#6d7175;margin-bottom:12px;">Accepted payment methods:</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <span class="badge badge-delivered">Cash on Delivery</span>
            <span class="badge badge-confirmed">UPI</span>
            <span class="badge badge-shipped">Cards</span>
        </div>
    </div>
</div>
@endsection
