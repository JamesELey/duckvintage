@extends('layouts.app')

@section('title', 'Home - Duck Vintage')

@section('content')
<div class="hero-section" style="position: relative; height: 70vh; overflow: hidden; margin-bottom: 3rem;">
    <!-- Hero Image 1 -->
    <div class="hero-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('six_duck_01.png') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; animation: fadeInOut 12s infinite;">
        <div class="container" style="text-align: center; z-index: 2;">
            <h1 style="font-size: 3rem; margin-bottom: 1rem; color: #FFD700; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Welcome to Duck Vintage</h1>
            <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #FFF; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">Discover timeless vintage clothing for the modern soul</p>
            <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Shop Now</a>
        </div>
    </div>
    
    <!-- Hero Image 2 -->
    <div class="hero-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('six_duck_02.png') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; animation: fadeInOut 12s infinite 3s;">
        <div class="container" style="text-align: center; z-index: 2;">
            <h1 style="font-size: 3rem; margin-bottom: 1rem; color: #FFD700; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Quality Vintage Finds</h1>
            <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #FFF; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">Curated collection of authentic vintage pieces</p>
            <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Explore Collection</a>
        </div>
    </div>
    
    <!-- Hero Image 3 -->
    <div class="hero-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('six_duck_03.png') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; animation: fadeInOut 12s infinite 6s;">
        <div class="container" style="text-align: center; z-index: 2;">
            <h1 style="font-size: 3rem; margin-bottom: 1rem; color: #FFD700; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Authentic Vintage Style</h1>
            <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #FFF; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">Experience the charm of classic fashion</p>
            <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Discover More</a>
        </div>
    </div>
    
    <!-- Hero Image 4 -->
    <div class="hero-slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('six_duck_04.png') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; animation: fadeInOut 12s infinite 9s;">
        <div class="container" style="text-align: center; z-index: 2;">
            <h1 style="font-size: 3rem; margin-bottom: 1rem; color: #FFD700; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Timeless Fashion</h1>
            <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #FFF; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">Where vintage meets modern elegance</p>
            <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Shop Vintage</a>
        </div>
    </div>
    
    <!-- CSS Animation -->
    <style>
        @keyframes fadeInOut {
            0%, 20% { opacity: 1; }
            25%, 100% { opacity: 0; }
        }
        
        .hero-slide {
            opacity: 0;
        }
    </style>
</div>

<div class="container">
    <!-- Categories Section -->
    <section style="margin-bottom: 4rem;">
        <h2 style="text-align: center; margin-bottom: 2rem; font-size: 2rem;">Shop by Category</h2>
        <div class="grid grid-4">
            @foreach($categories as $category)
            <div class="product-card">
                <a href="{{ route('categories.show', $category) }}" style="text-decoration: none; color: inherit;">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="product-image">
                    @else
                        <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                            {{ $category->name }}
                        </div>
                    @endif
                    <div class="product-info">
                        <h3 class="product-title">{{ $category->name }}</h3>
                        @if($category->description)
                            <p style="font-size: 0.9rem; color: #CCC;">{{ Str::limit($category->description, 100) }}</p>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Products Section -->
    <section>
        <h2 style="text-align: center; margin-bottom: 2rem; font-size: 2rem;">Featured Products</h2>
        <div class="grid grid-4">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit;">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                            No Image
                        </div>
                    @endif
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p style="font-size: 0.9rem; color: #CCC; margin-bottom: 0.5rem;">{{ $product->category->name }}</p>
                        <div class="product-price">
                            @if($product->sale_price)
                                <span class="product-sale-price">${{ number_format($product->price, 2) }}</span>
                                ${{ number_format($product->sale_price, 2) }}
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </div>
                        @if($product->sale_price)
                            <span style="color: #FF6B6B; font-size: 0.8rem;">{{ $product->discount_percentage }}% OFF</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        @if($featuredProducts->count() > 0)
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">View All Products</a>
            </div>
        @endif
    </section>
</div>
@endsection


