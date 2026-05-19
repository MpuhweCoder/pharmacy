<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'medicine_id',
        'quantity',
        'price',
        'discount',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────

    /** Item belongs to a cart */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /** Item belongs to a medicine */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────

    /**
     * Final price per unit after discount
     */
    public function getUnitPriceAttribute(): float
    {
        if ($this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100), 2);
        }
        return (float) $this->price;
    }

    /**
     * Subtotal for this item (unit price × quantity)
     */
    public function getSubtotalAttribute(): float
    {
        return round($this->unit_price * $this->quantity, 2);
    }
}