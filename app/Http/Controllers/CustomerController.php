<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** Customer dashboard */
    public function dashboard()
    {
        $user = auth()->user();
        
        $recent_orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $total_orders = Order::where('user_id', $user->id)->count();
        $pending_orders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $total_spent = Order::where('user_id', $user->id)
            ->sum('total') ?? 0;

        return view('customer.dashboard', compact(
            'user',
            'recent_orders',
            'total_orders',
            'pending_orders',
            'total_spent'
        ));
    }
}
