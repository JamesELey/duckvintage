@extends('layouts.app')

@section('title', 'Register - Duck Vintage')

@section('content')
<div class="container">
    <div style="max-width: 400px; margin: 0 auto; padding: 2rem 0;">
        <div class="card">
            <div class="card-header">
                <h2 style="text-align: center;">Create Account</h2>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                    @error('name')
                        <span style="color: #FF6B6B; font-size: 0.9rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
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
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-bottom: 1rem;">Create Account</button>
            </form>
            
            <div style="text-align: center;">
                <p style="color: #CCC;">Already have an account? <a href="{{ route('login') }}" style="color: #FFD700;">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection


