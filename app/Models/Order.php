<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'subtotal', 'shipping_cost', 'total',
        'payment_method', 'payment_status', 'status', 'notes',
        'payment_phone', 'transaction_id'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'LAH';
        $number = str_pad((string) (self::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT);
        return $prefix . date('Ymd') . $number;
    }
}
