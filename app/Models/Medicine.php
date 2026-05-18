<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'brand',
        'generic_name',
        'description',
        'price',
        'cost_price',
        'discount',
        'stock',
        'min_stock_alert',
        'dosage',
        'form',
        'expiry_date',
        'image',
        'requires_prescription',
        'is_active',
    ];

    protected $casts = [
        'expiry_date'            => 'date',
        'requires_prescription'  => 'boolean',
        'is_active'              => 'boolean',
        'price'                  => 'decimal:2',
        'cost_price'             => 'decimal:2',
        'discount'               => 'decimal:2',
    ];

    // ─── Boot: Auto-generate slug ──────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($medicine) {
            if (empty($medicine->slug)) {
                $medicine->slug = Str::slug($medicine->name) . '-' . uniqid();
            }
        });
    }

    // ─── Relationships ─────────────────────────────────────────────────────

    /** Medicine belongs to a category */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ─── Accessor: Final price after discount ──────────────────────────────

    public function getFinalPriceAttribute(): float
    {
        if ($this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100), 2);
        }
        return $this->price;
    }

    // ─── Accessor: Image URL ───────────────────────────────────────────────

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        // Return placeholder image
        return asset('images/medicine-placeholder.png');
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    /** Only active medicines */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** In-stock medicines only */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /** Low stock medicines */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock_alert')
                     ->where('stock', '>', 0);
    }

    /** Expired medicines */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
                     ->where('expiry_date', '<', now());
    }

    // ─── Helper Methods ────────────────────────────────────────────────────

    /** Is medicine expired? */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /** Is stock low? */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock_alert;
    }
}