<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_method',
        'payment_status',
        'subtotal',
        'discount_amount',
        'delivery_charge',
        'total_amount',
        'delivery_name',
        'delivery_phone',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_pincode',
        'notes',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'total_amount'    => 'decimal:2',
        'confirmed_at'    => 'datetime',
        'shipped_at'      => 'datetime',
        'delivered_at'    => 'datetime',
        'cancelled_at'    => 'datetime',
    ];

    // ─── Status constants ──────────────────────────────────────────────────

    const STATUS_PENDING    = 'pending';
    const STATUS_CONFIRMED  = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED    = 'shipped';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';

    // ─── Relationships ─────────────────────────────────────────────────────

    /** Order belongs to a customer */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Order has many items */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    /**
     * Get badge color for status
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'warning',
            'confirmed'  => 'info',
            'processing' => 'primary',
            'shipped'    => 'secondary',
            'delivered'  => 'success',
            'cancelled'  => 'danger',
            default      => 'secondary',
        };
    }

    /**
     * Get badge color for payment status
     */
    public function getPaymentBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => 'success',
            'failed'   => 'danger',
            'refunded' => 'warning',
            default    => 'secondary',
        };
    }

    /**
     * Can this order be cancelled?
     * Only pending and confirmed orders can be cancelled
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Generate a unique order number
     * Format: MED-YYYY-XXXXX
     */
    public static function generateOrderNumber(): string
    {
        $year   = date('Y');
        $latest = self::whereYear('created_at', $year)->count() + 1;
        return 'MED-' . $year . '-' . str_pad($latest, 5, '0', STR_PAD_LEFT);
    }
}