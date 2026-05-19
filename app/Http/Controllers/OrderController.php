<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Constructor: ensure user is logged in for all order actions
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ─── Checkout Page ─────────────────────────────────────────────────────

    /**
     * Show checkout form with cart summary
     */
    public function checkout()
    {
        // Get active cart
        $cart = Cart::where('user_id', Auth::id())
                    ->active()
                    ->with('items.medicine')
                    ->first();

        // Redirect if cart is empty
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty. Add medicines before checkout.');
        }

        // Pre-fill delivery info from user profile
        $user = Auth::user();

        return view('orders.checkout', compact('cart', 'user'));
    }

    // ─── Place Order ───────────────────────────────────────────────────────

    /**
     * Place the order — convert cart to order
     */
    public function store(PlaceOrderRequest $request)
    {
        // Get active cart with items
        $cart = Cart::where('user_id', Auth::id())
                    ->active()
                    ->with('items.medicine')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty.');
        }

        // Validate all items are still in stock before placing order
        foreach ($cart->items as $item) {
            if ($item->medicine->stock < $item->quantity) {
                return back()->with('error',
                    "{$item->medicine->name} only has {$item->medicine->stock} units left. Please update your cart."
                );
            }
        }

        // Calculate totals
        $subtotal       = $cart->final_amount;
        $discountAmount = $cart->total_discount;
        $deliveryCharge = $subtotal >= 500 ? 0 : 40;
        $totalAmount    = $subtotal + $deliveryCharge;

        // Wrap everything in a database transaction
        // If anything fails, everything rolls back
        DB::transaction(function () use ($request, $cart, $subtotal, $discountAmount, $deliveryCharge, $totalAmount) {

            // 1. Create the order
            $order = Order::create([
                'user_id'          => Auth::id(),
                'order_number'     => Order::generateOrderNumber(),
                'status'           => Order::STATUS_PENDING,
                'payment_method'   => $request->payment_method,
                'payment_status'   => $request->payment_method === 'cod' ? 'pending' : 'pending',
                'subtotal'         => $subtotal,
                'discount_amount'  => $discountAmount,
                'delivery_charge'  => $deliveryCharge,
                'total_amount'     => $totalAmount,
                'delivery_name'    => $request->delivery_name,
                'delivery_phone'   => $request->delivery_phone,
                'delivery_address' => $request->delivery_address,
                'delivery_city'    => $request->delivery_city,
                'delivery_state'   => $request->delivery_state,
                'delivery_pincode' => $request->delivery_pincode,
                'notes'            => $request->notes,
            ]);

            // 2. Create order items from cart items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'medicine_id'    => $item->medicine_id,
                    'medicine_name'  => $item->medicine->name,
                    'medicine_brand' => $item->medicine->brand,
                    'quantity'       => $item->quantity,
                    'unit_price'     => $item->unit_price,
                    'original_price' => $item->price,
                    'discount'       => $item->discount,
                    'subtotal'       => $item->subtotal,
                ]);

                // 3. Deduct stock for each medicine
                $item->medicine->decrement('stock', $item->quantity);
            }

            // 4. Mark cart as converted (not active anymore)
            $cart->update(['status' => 'converted']);

        });

        // Get the newly created order for confirmation page
        $order = Order::where('user_id', Auth::id())
                      ->latest()
                      ->first();

        return redirect()->route('orders.confirmation', $order)
                         ->with('success', "Order {$order->order_number} placed successfully!");
    }

    // ─── Order Confirmation ────────────────────────────────────────────────

    /**
     * Show order confirmation page
     */
    public function confirmation(Order $order)
    {
        // Security: ensure order belongs to logged-in user
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items.medicine');

        return view('orders.confirmation', compact('order'));
    }

    // ─── Order History ─────────────────────────────────────────────────────

    /**
     * Customer's order history
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items')
                       ->latest()
                       ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // ─── Order Detail ──────────────────────────────────────────────────────

    /**
     * View a single order's details
     */
    public function show(Order $order)
    {
        // Security: ensure this order belongs to the logged-in user
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items.medicine');

        return view('orders.show', compact('order'));
    }

    // ─── Cancel Order ──────────────────────────────────────────────────────

    /**
     * Customer cancels their own order
     */
    public function cancel(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if (!$order->isCancellable()) {
            return back()->with('error',
                'This order cannot be cancelled as it is already ' . $order->status . '.'
            );
        }

        DB::transaction(function () use ($order) {
            // Restore stock for each item
            foreach ($order->items as $item) {
                $item->medicine->increment('stock', $item->quantity);
            }

            // Update order status
            $order->update([
                'status'       => Order::STATUS_CANCELLED,
                'cancelled_at' => now(),
            ]);
        });

        return back()->with('success', 'Order cancelled and stock has been restored.');
    }
}