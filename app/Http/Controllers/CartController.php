<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ─── Helper: Get or create active cart ────────────────────────────────

    /**
     * Get the current user's active cart.
     * If logged in → use user_id
     * If guest    → use session_id
     * If user just logged in → merge session cart into user cart
     */
    private function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            // Try to find existing active cart for this user
            $cart = Cart::where('user_id', Auth::id())
                        ->active()
                        ->first();

            if (!$cart) {
                // Check if there's a guest cart in session to merge
                $sessionId = session()->getId();
                $guestCart = Cart::where('session_id', $sessionId)
                                 ->active()
                                 ->first();

                if ($guestCart) {
                    // Assign guest cart to logged-in user
                    $guestCart->update([
                        'user_id'    => Auth::id(),
                        'session_id' => null,
                    ]);
                    return $guestCart;
                }

                // Create fresh cart for user
                $cart = Cart::create(['user_id' => Auth::id()]);
            }

            return $cart;
        }

        // Guest user — use session ID
        $sessionId = session()->getId();

        return Cart::firstOrCreate(
            ['session_id' => $sessionId, 'status' => 'active'],
            ['session_id' => $sessionId]
        );
    }

    // ─── Show Cart Page ────────────────────────────────────────────────────

    /**
     * Display the cart with all items
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();

        // Load items with medicine and category details
        $cart->load('items.medicine.category');

        return view('cart.index', compact('cart'));
    }

    // ─── Add to Cart ───────────────────────────────────────────────────────

    /**
     * Add a medicine to the cart
     */
    public function add(AddToCartRequest $request)
    {
        $medicine = Medicine::findOrFail($request->medicine_id);

        // Check if medicine is active and in stock
        if (!$medicine->is_active) {
            return back()->with('error', 'This medicine is not available.');
        }

        if ($medicine->stock < $request->quantity) {
            return back()->with('error',
                "Only {$medicine->stock} units available for {$medicine->name}."
            );
        }

        // Check prescription requirement
        if ($medicine->requires_prescription && !Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Please login to add prescription medicines.');
        }

        $cart = $this->getOrCreateCart();

        // Check if medicine already exists in cart
        $existingItem = CartItem::where('cart_id', $cart->id)
                                ->where('medicine_id', $medicine->id)
                                ->first();

        if ($existingItem) {
            // Update quantity, but don't exceed stock
            $newQuantity = $existingItem->quantity + $request->quantity;

            if ($newQuantity > $medicine->stock) {
                return back()->with('error',
                    "Cannot add more. Only {$medicine->stock} units in stock."
                );
            }

            $existingItem->update(['quantity' => $newQuantity]);
            $message = "{$medicine->name} quantity updated in cart.";
        } else {
            // Add new item to cart
            CartItem::create([
                'cart_id'     => $cart->id,
                'medicine_id' => $medicine->id,
                'quantity'    => $request->quantity,
                'price'       => $medicine->price,   // save current price
                'discount'    => $medicine->discount, // save current discount
            ]);
            $message = "{$medicine->name} added to cart!";
        }

        // If AJAX request, return JSON
        if ($request->expectsJson()) {
            $cart->load('items');
            return response()->json([
                'success'    => true,
                'message'    => $message,
                'cart_count' => $cart->total_items,
            ]);
        }

        return back()->with('success', $message);
    }

    // ─── Update Quantity ───────────────────────────────────────────────────

    /**
     * Update quantity of a cart item
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        // Make sure this item belongs to current user's cart
        $cart = $this->getOrCreateCart();

        if ($cartItem->cart_id !== $cart->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check stock availability
        $medicine = $cartItem->medicine;

        if ($request->quantity > $medicine->stock) {
            return back()->with('error',
                "Only {$medicine->stock} units available."
            );
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    // ─── Remove Item ───────────────────────────────────────────────────────

    /**
     * Remove a specific item from cart
     */
    public function remove(CartItem $cartItem)
    {
        // Security: make sure item belongs to current cart
        $cart = $this->getOrCreateCart();

        if ($cartItem->cart_id !== $cart->id) {
            abort(403, 'Unauthorized action.');
        }

        $medicineName = $cartItem->medicine->name;
        $cartItem->delete();

        return back()->with('success', "{$medicineName} removed from cart.");
    }

    // ─── Clear Cart ────────────────────────────────────────────────────────

    /**
     * Remove all items from cart
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return back()->with('success', 'Cart has been cleared.');
    }

    // ─── Cart Count (for AJAX badge) ───────────────────────────────────────

    /**
     * Return cart item count as JSON (used for navbar badge)
     */
    public function count()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items');

        return response()->json([
            'count' => $cart->total_items,
        ]);
    }
}