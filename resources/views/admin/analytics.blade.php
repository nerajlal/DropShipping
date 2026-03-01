@extends('admin.layouts.app')
@section('page_title', 'Analytics')
@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e3f1df;color:#008060;"><i class="fas fa-chart-line"></i></div>
        <h3>₹0</h3>
        <p>Total Sales</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e3e8ff;color:#2c6ecb;"><i class="fas fa-eye"></i></div>
        <h3>0</h3>
        <p>Store Sessions</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff8e6;color:#b98900;"><i class="fas fa-undo"></i></div>
        <h3>0%</h3>
        <p>Return Rate</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ffe4e6;color:#d72c0d;"><i class="fas fa-percentage"></i></div>
        <h3>0%</h3>
        <p>Conversion Rate</p>
    </div>
</div>
<div class="admin-card">
    <h3><i class="fas fa-chart-bar"></i> Sales Over Time</h3>
    <div style="padding:60px 20px;text-align:center;color:#6d7175;">
        <i class="fas fa-chart-area" style="font-size:48px;color:#e1e3e5;margin-bottom:16px;display:block;"></i>
        <p>Analytics data will appear here once you start receiving orders.</p>
    </div>
</div>
@endsection
