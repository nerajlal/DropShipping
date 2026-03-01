@extends('admin.layouts.app')
@section('page_title', 'Content')
@section('content')
<div class="admin-card">
    <h3><i class="fas fa-file-alt"></i> Pages</h3>
    <div style="padding:40px 20px;text-align:center;color:#6d7175;">
        <i class="fas fa-file-alt" style="font-size:48px;color:#e1e3e5;margin-bottom:16px;display:block;"></i>
        <p>Create and manage store pages like About Us, Contact, FAQs, and more.</p>
        <a href="#" class="btn btn-primary" style="margin-top:16px;"><i class="fas fa-plus"></i> Add page</a>
    </div>
</div>
<div class="admin-card">
    <h3><i class="fas fa-blog"></i> Blog Posts</h3>
    <div style="padding:40px 20px;text-align:center;color:#6d7175;">
        <i class="fas fa-pen-fancy" style="font-size:48px;color:#e1e3e5;margin-bottom:16px;display:block;"></i>
        <p>Write blog posts to drive traffic and engage your customers.</p>
        <a href="#" class="btn btn-primary" style="margin-top:16px;"><i class="fas fa-plus"></i> Create blog post</a>
    </div>
</div>
@endsection
