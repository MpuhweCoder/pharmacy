<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Auto-generate slug when name is set ──────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ─── Relationships ─────────────────────────────────────────────────────

    /** A category has many medicines */
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    /** Only return active categories */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}