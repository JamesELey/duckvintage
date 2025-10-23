<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check current password if changing password
        if ($request->password && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }

    public function exportData()
    {
        $user = auth()->user();
        
        // Gather all user data
        $data = [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
            'orders' => $user->orders()->with('items.product')->get()->toArray(),
            'cart_items' => $user->cartItems()->with('product')->get()->toArray(),
        ];
        
        $filename = 'duckvintage_data_export_' . date('Y-m-d_His') . '.json';
        
        return response()->json($data, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        
        // Prevent admin from deleting their own account
        if ($user->hasRole('admin')) {
            return back()->withErrors(['confirmation' => 'Admin accounts cannot be self-deleted. Please contact another administrator.']);
        }
        
        // Verify password first
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }
        
        // Validate confirmation
        $request->validate([
            'password' => 'required|string',
            'confirmation' => 'required|in:DELETE',
        ], [
            'confirmation.in' => 'You must type DELETE to confirm account deletion.'
        ]);
        
        // Remove all roles and permissions first
        $user->syncRoles([]);
        $user->syncPermissions([]);
        
        // Delete user account (cascade will handle related records)
        $user->delete();
        
        // Logout and redirect
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Your account has been permanently deleted.');
    }
}


