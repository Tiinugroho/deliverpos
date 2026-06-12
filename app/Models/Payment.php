<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'proof_of_payment',
        'status', // 'unverified', 'verified', 'rejected'
    ];

    // Relasi ke Order: Pembayaran ini untuk pesanan yang mana
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}