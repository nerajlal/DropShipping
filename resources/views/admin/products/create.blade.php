@extends('admin.layouts.app')
@section('page_title', 'Add Product')

@section('content')
<div class="admin-card" style="max-width:800px;">
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        @if($errors->any())<div class="alert alert-danger" style="margin:0 0 20px;"><ul style="margin:0;padding-left:20px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif

        <div class="form-row">
            <div class="form-group"><label>Product Name *</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="form-group"><label>Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand') }}"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Price (₹) *</label><input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01" required></div>
            <div class="form-group"><label>Compare Price (₹)</label><input type="number" name="compare_price" class="form-control" value="{{ old('compare_price') }}" step="0.01"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Category *</label><select name="category_id" class="form-control" required>@foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach</select></div>
            <div class="form-group"><label>Stock</label><input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}"></div>
        </div>
        <div class="form-group"><label>Short Description</label><textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea></div>
        <div class="form-group"><label>Full Description (HTML)</label><textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea></div>
        <div class="form-group"><label>Image URL</label><input type="text" name="image" class="form-control" value="{{ old('image') }}" placeholder="https://..."></div>
        <div class="form-row">
            <div class="form-group"><label>Supplier Name</label><input type="text" name="supplier_name" class="form-control" value="{{ old('supplier_name', 'CJ Dropshipping') }}"></div>
            <div class="form-group"><label>Shipping Time</label><input type="text" name="shipping_time" class="form-control" value="{{ old('shipping_time', '3-7 days') }}"></div>
        </div>
        <div style="display:flex;gap:12px;margin-top:8px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
