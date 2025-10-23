@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit User: {{ $user->name }}</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">Select a role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Password Reset Section -->
<div class="card mt-4">
    <div class="card-header">
        <h3>Reset Password</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <p class="text-muted mb-3">Use this form to reset the user's password. They will need to use the new password on their next login.</p>
            
            <div class="form-group">
                <label for="reset_password" class="form-label">New Password *</label>
                <input type="password" id="reset_password" name="password" class="form-control" required minlength="8">
                @error('password')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="reset_password_confirmation" class="form-label">Confirm New Password *</label>
                <input type="password" id="reset_password_confirmation" name="password_confirmation" class="form-control" required minlength="8">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-warning">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
