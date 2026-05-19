<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────

    /** Cart belongs to a user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Cart has many items */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /** Cart items with their medicines loaded */
    public function itemsWithMedicine()
    {
        return $this->hasMany(CartItem::class)->with('medicine');
    }

    // ─── Accessors ─────────────────────────────────────────────────────────

    /**
     * Total number of items in cart (sum of quantities)
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Total price of all items in cart
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->subtotal;
        });
    }

    /**
     * Total discount amount
     */
    public function getTotalDiscountAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return ($item->price * $item->discount / 100) * $item->quantity;
        });
    }

    /**
     * Final payable amount
     */
    public function getFinalAmountAttribute(): float
    {
        return $this->total_price - $this->total_discount;
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    /** Only active carts */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}