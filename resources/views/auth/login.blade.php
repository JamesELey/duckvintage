@extends('layouts.app')

@section('title', 'Login - Duck Vintage')

@section('content')
<div class="container">
    <div style="max-width: 400px; margin: 0 auto; padding: 2rem 0;">
        <div class="card">
            <div class="card-header">
                <h2 style="text-align: center;">Login</h2>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    @error('email')
                        <span style="color: #FF6B6B; font-size: 0.9rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <span style="color: #FF6B6B; font-size: 0.9rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-bottom: 1rem;">Login</button>
            </form>
            
            <div style="text-align: center;">
                <p style="color: #CCC;">Don't have an account? <a href="{{ route('register') }}" style="color: #FFD700;">Register here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection


