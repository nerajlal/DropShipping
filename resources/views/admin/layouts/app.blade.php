<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - TechDrop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                <span class="logo-text">Tech<span style="color:#a29bfe;">Drop</span></span>
                <small>ADMIN</small>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fas fa-box"></i> Products</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Orders</a>
                <div class="sidebar-divider"></div>
                <a href="{{ route('home') }}" target="_blank"><i class="fas fa-external-link-alt"></i> View Store</a>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button></form>
            </nav>
        </aside>
        <main class="admin-main">
            <header class="admin-header">
                <h1>@yield('page_title', 'Dashboard')</h1>
                <div class="header-user"><i class="fas fa-user-circle"></i> {{ auth()->user()->name }}</div>
            </header>
            @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif
            <div class="admin-content">@yield('content')</div>
        </main>
    </div>
</body>
</html>
