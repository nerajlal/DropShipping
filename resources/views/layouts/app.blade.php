<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TechDrop - Premium Tech Gadgets')</title>
    <meta name="description" content="@yield('meta_description', 'Discover premium tech gadgets at unbeatable prices. Fast delivery, quality guaranteed.')">

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    {{-- Toast Notifications --}}
    <div id="toast-container"></div>

    {{-- Navigation --}}
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="{{ route('home') }}" class="nav-logo">
                    <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                    <span class="logo-text">Tech<span class="logo-accent">Drop</span></span>
                </a>

                <div class="nav-search" id="navSearch">
                    <form action="{{ route('products.index') }}" method="GET" class="search-form">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" placeholder="Search gadgets, brands, categories..." value="{{ request('search') }}" autocomplete="off">
                        <button type="submit" class="search-btn">Search</button>
                    </form>
                </div>

                <div class="nav-actions">
                    <a href="{{ route('products.index') }}" class="nav-link"><i class="fas fa-th-large"></i><span>Store</span></a>

                    @auth
                        <a href="{{ route('account.index') }}" class="nav-link"><i class="fas fa-user"></i><span>Account</span></a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-user"></i><span>Login</span></a>
                    @endauth

                    <a href="{{ route('cart.index') }}" class="nav-link cart-link" id="cartLink">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-badge" id="cartBadge">{{ app(App\Http\Controllers\CartController::class)->getCartCount() }}</span>
                        <span>Cart</span>
                    </a>
                </div>

                <button class="mobile-toggle" id="mobileToggle">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-inner">
            <form action="{{ route('products.index') }}" method="GET" class="mobile-search">
                <input type="text" name="search" placeholder="Search products...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
            <a href="{{ route('products.index') }}"><i class="fas fa-th-large"></i> All Products</a>
            <a href="{{ route('cart.index') }}"><i class="fas fa-shopping-bag"></i> Cart</a>
            @auth
                <a href="{{ route('account.index') }}"><i class="fas fa-user"></i> My Account</a>
                <form action="{{ route('logout') }}" method="POST" class="mobile-logout">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a>
            @endauth
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}', 'success'));</script>
    @endif
    @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast('{{ session('error') }}', 'error'));</script>
    @endif

    {{-- Page Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                        <span class="logo-text">Tech<span class="logo-accent">Drop</span></span>
                    </div>
                    <p class="footer-desc">Your premium destination for the latest tech gadgets. Quality products, unbeatable prices, fast delivery.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">All Products</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                        <li><a href="{{ route('account.index') }}">My Account</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Categories</h4>
                    <ul>
                        @php $footerCategories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->get(); @endphp
                        @foreach($footerCategories as $cat)
                            <li><a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Return Policy</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} TechDrop. All rights reserved. Powered by CJ Dropshipping.</p>
                <div class="footer-payments">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-google-pay"></i>
                    <i class="fab fa-paypal"></i>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
