@extends('admin.layouts.app')
@section('page_title', 'Order ' . $order->order_number)

@section('content')
<div style="margin-bottom:12px;"><a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to Orders</a></div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;">
    <div>
        <div class="admin-card">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:20px 20px 0;">
                <h3 style="padding:0;">Order Items</h3>
                <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div style="padding:0 20px 20px;">
                @foreach($order->items as $item)
                    <div style="display:flex;gap:14px;align-items:center;padding:12px 0;border-bottom:1px solid #e1e3e5;">
                        <img src="{{ $item->product->image ?? '' }}" style="width:48px;height:48px;border-radius:6px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/48/f6f6f7/6d7175?text=TD'">
                        <div style="flex:1;"><p style="font-weight:500;">{{ $item->product_name }}</p><small style="color:#6d7175;">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 0) }}</small></div>
                        <span style="font-weight:600;">₹{{ number_format($item->total, 0) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card">
            <h3>Shipping Address</h3>
            <div style="padding:0 20px 20px;">
                <p style="font-size:14px;color:#6d7175;line-height:1.8;"><strong style="color:#202223;">{{ $order->shipping_name }}</strong><br>{{ $order->shipping_address }}<br>{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zipcode }}<br>📞 {{ $order->shipping_phone }} | ✉ {{ $order->shipping_email }}</p>
            </div>
        </div>
    </div>

    <div>
        <div class="admin-card">
            <h3>Summary</h3>
            <div style="padding:0 20px 20px;">
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:14px;"><span style="color:#6d7175;">Subtotal</span><span>₹{{ number_format($order->subtotal, 0) }}</span></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:14px;"><span style="color:#6d7175;">Shipping</span><span>{{ $order->shipping_cost == 0 ? 'FREE' : '₹'.number_format($order->shipping_cost, 0) }}</span></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:14px;"><span style="color:#6d7175;">Tax</span><span>₹{{ number_format($order->tax, 0) }}</span></div>
                @if($order->discount > 0)<div style="display:flex;justify-content:space-between;padding:8px 0;font-size:14px;"><span style="color:#6d7175;">Discount</span><span style="color:#008060;">-₹{{ number_format($order->discount, 0) }}</span></div>@endif
                <div style="display:flex;justify-content:space-between;padding:12px 0;font-size:16px;font-weight:600;border-top:1px solid #e1e3e5;margin-top:8px;"><span>Total</span><span>₹{{ number_format($order->total, 0) }}</span></div>
                <div style="margin-top:8px;font-size:13px;color:#6d7175;"><strong>Payment:</strong> {{ ucfirst(str_replace('_',' ',$order->payment_method)) }}<br><strong>Status:</strong> <span class="badge badge-{{ $order->payment_status === 'paid' ? 'delivered' : 'pending' }}">{{ ucfirst($order->payment_status) }}</span></div>
            </div>
        </div>

        <div class="admin-card">
            <h3>Update Status</h3>
            <div style="padding:0 20px 20px;">
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-group"><label>Status</label><select name="status" class="form-control">
                        @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select></div>
                    <div class="form-group"><label>Tracking Number</label><input type="text" name="tracking_number" class="form-control" value="{{ $order->tracking_number }}"></div>
                    <div class="form-group"><label>Tracking URL</label><input type="text" name="tracking_url" class="form-control" value="{{ $order->tracking_url }}"></div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
