<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'medicine_id',
        'medicine_name',
        'medicine_brand',
        'quantity',
        'unit_price',
        'original_price',
        'discount',
        'subtotal',
    ];

    protected $casts = [
        'unit_price'     => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount'       => 'decimal:2',
        'subtotal'       => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}