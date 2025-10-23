@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Users Management</h2>
            <a href="{{ route('admin.users.create') }}" class="btn">Add New User</a>
        </div>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="badge">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge" style="background-color: #6c757d;">No Role</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn" style="margin-right: 0.5rem;">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary" style="margin-right: 0.5rem;">Edit</a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 2rem;">
                <h3>No users found</h3>
                <p>Get started by creating your first user.</p>
                <a href="{{ route('admin.users.create') }}" class="btn">Create User</a>
            </div>
        @endif
    </div>
</div>
@endsection
