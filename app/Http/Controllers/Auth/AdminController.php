<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    /** Admin dashboard */
    public function dashboard()
    {
        // Summary statistics for admin
        $stats = [
            'total_users'        => User::count(),
            'total_customers'    => User::where('role', 'customer')->count(),
            'total_pharmacists'  => User::where('role', 'pharmacist')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /** List all users */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
    }

    /** Toggle user active/inactive */
    public function toggleUser(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User has been {$status}.");
    }
}