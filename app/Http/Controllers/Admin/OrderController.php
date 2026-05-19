<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List all orders with filters
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])
                      ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('delivery_name', 'like', "%{$search}%")
                  ->orWhere('delivery_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        // Stats for filter badges
        $stats = [
            'all'        => Order::count(),
            'pending'    => Order::pending()->count(),
            'confirmed'  => Order::where('status', 'confirmed')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::delivered()->count(),
            'cancelled'  => Order::cancelled()->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * View single order details (admin view)
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.medicine']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,delivered,cancelled'],
        ]);

        $timestamps = [];

        // Set appropriate timestamp based on new status
        $timestamps = match($request->status) {
            'confirmed'  => ['confirmed_at'  => now()],
            'shipped'    => ['shipped_at'    => now()],
            'delivered'  => [
                'delivered_at'  => now(),
                'payment_status' => $order->payment_method === 'cod' ? 'paid' : $order->payment_status,
            ],
            'cancelled'  => ['cancelled_at' => now()],
            default      => [],
        };

        // If cancelling from admin side, restore stock
        if ($request->status === 'cancelled' && $order->status !== 'cancelled') {
            DB::transaction(function () use ($order, $request, $timestamps) {
                foreach ($order->items as $item) {
                    $item->medicine->increment('stock', $item->quantity);
                }
                $order->update(array_merge(
                    ['status' => $request->status],
                    $timestamps
                ));
            });
        } else {
            $order->update(array_merge(
                ['status' => $request->status],
                $timestamps
            ));
        }

        return back()->with('success',
            "Order #{$order->order_number} status updated to " . ucfirst($request->status) . "."
        );
    }

    /**
     * Dashboard revenue and order statistics
     */
    public function statistics()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::delivered()->sum('total_amount'),
            'pending_orders'  => Order::pending()->count(),
            'today_orders'    => Order::whereDate('created_at', today())->count(),
            'today_revenue'   => Order::whereDate('created_at', today())
                                      ->delivered()
                                      ->sum('total_amount'),
        ];

        // Orders per month for chart (last 6 months)
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
                              ->whereYear('created_at', date('Y'))
                              ->groupBy('month')
                              ->orderBy('month')
                              ->get();

        return compact('stats', 'monthlyOrders');
    }
}