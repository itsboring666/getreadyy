<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_value',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Determine if the coupon is valid and eligible.
     */
    public function isValidFor($subtotal): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($subtotal < $this->min_order_value) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount.
     */
    public function getDiscountAmount($subtotal): float
    {
        if ($this->type === 'percent') {
            return round(($subtotal * $this->value) / 100, 2);
        }

        // Fixed discount amount cannot exceed subtotal
        return min($this->value, $subtotal);
    }
}
