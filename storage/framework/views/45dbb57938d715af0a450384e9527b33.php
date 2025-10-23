<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Duck Vintage')); ?> - <?php echo $__env->yieldContent('title', 'Vintage Clothing Store'); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('duck_fav.png')); ?>?v=<?php echo e(time()); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('duck_fav.png')); ?>?v=<?php echo e(time()); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('duck_fav.png')); ?>?v=<?php echo e(time()); ?>">

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
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="<?php echo e(route('home')); ?>" class="logo" style="display: flex; align-items: center; gap: 0.5rem;">
                    <img src="<?php echo e(asset('duck_fav.png')); ?>" alt="Duck Vintage" style="height: 32px; width: 32px;">
                    <span>Duck Vintage</span>
                </a>
                
                <nav class="nav">
                    <a href="<?php echo e(route('home')); ?>">Home</a>
                    <a href="<?php echo e(route('products.index')); ?>">Products</a>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('cart.index')); ?>" class="cart-icon">
                            Cart
                            <?php if(auth()->user()->cart_items_count > 0): ?>
                                <span class="cart-count"><?php echo e(auth()->user()->cart_items_count); ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo e(route('orders.index')); ?>">Orders</a>
                        <a href="<?php echo e(route('profile.show')); ?>">Profile</a>
                        
                        <?php if(auth()->user()->hasRole('admin')): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>
                        <a href="<?php echo e(route('register')); ?>">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> Duck Vintage. All rights reserved.</p>
            <p>Vintage clothing for the modern soul.</p>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>


<?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/layouts/app.blade.php ENDPATH**/ ?>