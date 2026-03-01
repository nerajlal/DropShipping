<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'subtotal', 'shipping_cost', 'tax', 'discount',
        'total', 'status', 'payment_status', 'payment_method', 'transaction_id',
        'shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_state', 'shipping_zipcode', 'shipping_country',
        'tracking_number', 'tracking_url', 'supplier_order_id', 'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'TD-' . strtoupper(uniqid());
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipped' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary',
        };
    }
}
