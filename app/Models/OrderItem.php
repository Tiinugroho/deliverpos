<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_purchase',
    ];

    // Relasi ke Order induk
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relasi ke Product: Item ini merujuk ke produk yang mana
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}