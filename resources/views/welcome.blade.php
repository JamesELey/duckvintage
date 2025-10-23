@extends('layouts.app')

@section('title', 'Welcome - Duck Vintage')

@section('content')
<div class="container">
    <div style="text-align: center; padding: 4rem 0;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; color: #FFD700;">Welcome to Duck Vintage</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #FFF;">Your premier destination for vintage clothing</p>
        
        <div style="margin-bottom: 3rem;">
            <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem; margin-right: 1rem;">Browse Products</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary" style="font-size: 1.1rem; padding: 1rem 2rem;">Create Account</a>
            @endguest
        </div>

        <div class="grid grid-3" style="margin-top: 3rem;">
            <div style="text-align: center;">
                <h3 style="color: #FFD700; margin-bottom: 1rem;">Quality Vintage</h3>
                <p style="color: #CCC;">Carefully curated vintage pieces from authentic sources</p>
            </div>
            <div style="text-align: center;">
                <h3 style="color: #FFD700; margin-bottom: 1rem;">Unique Style</h3>
                <p style="color: #CCC;">Stand out with one-of-a-kind vintage clothing</p>
            </div>
            <div style="text-align: center;">
                <h3 style="color: #FFD700; margin-bottom: 1rem;">Fast Shipping</h3>
                <p style="color: #CCC;">Quick and secure delivery to your doorstep</p>
            </div>
        </div>
    </div>
</div>
@endsection


