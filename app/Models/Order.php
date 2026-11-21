<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kiosk_id',
        'order_code',
        'total_price',
        'status',
        'payment_status',
        'payment_type',
        'snap_token',
        'pickup_session',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kiosk()
    {
        return $this->belongsTo(Kiosk::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function formattedTotal(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
