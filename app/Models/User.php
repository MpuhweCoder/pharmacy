<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'is_active',
    ];

    /**
     * Fields hidden from JSON responses
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Field type casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ─── Role Helper Methods ───────────────────────────────────────────────

    /** Check if user is admin */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Check if user is pharmacist */
    public function isPharmacist(): bool
    {
        return $this->role === 'pharmacist';
    }

    /** Check if user is customer */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // ─── Relationships ─────────────────────────────────────────────────────

    /** A customer can have many orders */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    /** A customer can have many prescriptions */
    public function prescriptions()
    {
        return $this->hasMany(\App\Models\Prescription::class);
    }
}