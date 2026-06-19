<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'total_amount',
        'status',
        'name',
        'email',
        'phone',
        'city',
        'state',
        'zip',
        'address',
        'tracking_number',
        'shipping_fee',
        'coupon_code',
        'discount_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
