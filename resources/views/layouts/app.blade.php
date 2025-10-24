<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Duck Vintage - Premium Vintage Clothing & Accessories')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Discover premium vintage clothing and accessories at Duck Vintage. Unique pieces from different eras, curated for the modern soul.')">
    <meta name="keywords" content="vintage clothing, retro fashion, vintage store, second-hand clothing, sustainable fashion, vintage accessories">
    <meta name="author" content="Duck Vintage">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Duck Vintage - Premium Vintage Clothing')">
    <meta property="og:description" content="@yield('meta_description', 'Discover premium vintage clothing and accessories at Duck Vintage.')">
    <meta property="og:image" content="{{ asset('duck_hero_01.png') }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Duck Vintage - Premium Vintage Clothing')">
    <meta name="twitter:description" content="@yield('meta_description', 'Discover premium vintage clothing and accessories.')">
    <meta name="twitter:image" content="{{ asset('duck_hero_01.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('duck_fav.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('duck_fav.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('duck_fav.png') }}">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#FFD700">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Duck Vintage">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #000000;
            color: #FFD700;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        .header {
            background-color: #000000;
            border-bottom: 2px solid #FFD700;
            padding: 1rem 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #FFD700;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav a {
            color: #FFD700;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav a:hover {
            color: #FFF;
        }

        .cart-icon {
            position: relative;
            color: #FFD700;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #FFD700;
            color: #000;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }

        /* Footer */
        .footer {
            background-color: #000000;
            border-top: 2px solid #FFD700;
            padding: 2rem 0;
            text-align: center;
            margin-top: 4rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #FFD700;
            color: #000;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #FFF;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            color: #FFD700;
            border: 2px solid #FFD700;
        }

        .btn-secondary:hover {
            background-color: #FFD700;
            color: #000;
        }

        /* Cards */
        .card {
            background-color: #111;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .card-header {
            border-bottom: 1px solid #333;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #FFD700;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            background-color: #111;
            border: 1px solid #333;
            border-radius: 4px;
            color: #FFD700;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #FFD700;
        }

        /* Grid */
        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        /* Product Cards */
        .product-card {
            background-color: #111;
            border: 1px solid #333;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: #FFD700;
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .product-info {
            padding: 1rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #FFD700;
        }

        .product-sale-price {
            color: #FF6B6B;
            text-decoration: line-through;
            margin-right: 0.5rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #1a4d1a;
            border: 1px solid #2d7a2d;
            color: #90EE90;
        }

        .alert-error {
            background-color: #4d1a1a;
            border: 1px solid #7a2d2d;
            color: #FFB6C1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .nav {
                gap: 1rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            .container {
                padding: 0 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 0.5rem;">
                    <img src="{{ asset('duck_fav.png') }}" alt="Duck Vintage" style="height: 32px; width: 32px;">
                    <span>Duck Vintage</span>
                </a>
                
                <nav class="nav">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('products.index') }}">Products</a>
                    <a href="{{ route('blog.index') }}">Blog</a>
                    
                    @auth
                        <a href="{{ route('cart.index') }}" class="cart-icon">
                            Cart
                            @if(auth()->user()->cart_items_count > 0)
                                <span class="cart-count">{{ auth()->user()->cart_items_count }}</span>
                            @endif
                        </a>
                        <a href="{{ route('orders.index') }}">Orders</a>
                        <a href="{{ route('profile.show') }}">Profile</a>
                        
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}">Admin</a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 1rem;">
                <img src="{{ asset('duck_footer.png') }}" alt="Duck Vintage Footer" style="height: 48px; width: auto;">
            </div>
            <p>&copy; {{ date('Y') }} Duck Vintage. All rights reserved.</p>
            <p>Vintage clothing for the modern soul.</p>
            <div style="margin-top: 1rem;">
                <a href="{{ route('privacy-policy') }}" style="color: #FFD700; margin: 0 0.5rem;">Privacy Policy</a>
                <a href="{{ route('terms-of-service') }}" style="color: #FFD700; margin: 0 0.5rem;">Terms of Service</a>
                <a href="{{ route('cookie-policy') }}" style="color: #FFD700; margin: 0 0.5rem;">Cookie Policy</a>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent Banner -->
    <div id="cookieConsent" style="display:none; position:fixed; bottom:0; left:0; right:0; background-color:#1a1a1a; border-top:2px solid #FFD700; padding:1.5rem; z-index:10000; box-shadow:0 -2px 10px rgba(0,0,0,0.5);">
        <div class="container" style="max-width:1200px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div style="flex:1; min-width:300px;">
                <p style="margin-bottom:0.5rem; font-weight:bold; color:#FFD700;">🍪 Cookie Notice</p>
                <p style="margin:0; font-size:0.9rem;">We use cookies to enhance your experience and analyze site traffic. By continuing to browse, you consent to our use of cookies. 
                <a href="{{ route('cookie-policy') }}" style="color:#FFD700; text-decoration:underline;">Learn more</a></p>
            </div>
            <div style="display:flex; gap:1rem;">
                <button onclick="acceptCookies()" class="btn" style="background-color:#28a745; padding:0.75rem 1.5rem; white-space:nowrap;">Accept All</button>
                <button onclick="declineCookies()" class="btn btn-secondary" style="padding:0.75rem 1.5rem; white-space:nowrap;">Decline Optional</button>
            </div>
        </div>
    </div>

    <script>
        // Cookie consent management
        function checkCookieConsent() {
            if (!localStorage.getItem('cookieConsent')) {
                document.getElementById('cookieConsent').style.display = 'block';
            }
        }

        function acceptCookies() {
            localStorage.setItem('cookieConsent', 'accepted');
            document.getElementById('cookieConsent').style.display = 'none';
            // Here you would enable analytics, marketing cookies, etc.
        }

        function declineCookies() {
            localStorage.setItem('cookieConsent', 'declined');
            document.getElementById('cookieConsent').style.display = 'none';
            // Only essential cookies remain active
        }

        // Check on page load
        window.addEventListener('DOMContentLoaded', checkCookieConsent);
        
        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('ServiceWorker registered:', registration.scope);
                    })
                    .catch((error) => {
                        console.log('ServiceWorker registration failed:', error);
                    });
            });
        }
    </script>

    @stack('scripts')
</body>
</html>


