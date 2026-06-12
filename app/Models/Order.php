<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Disesuaikan dengan skema tabel database katering.
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'order_date',
        'shipping_address',
        'note',
        'total_price',
        'status', // 'pending', 'confirmed', 'on_delivery', 'completed', 'cancelled'
    ];

    /**
     * Relasi ke User: Setiap pesanan katering mutlak milik satu pengguna
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * PERBAIKAN UTAMA: Mengubah nama fungsi dari orderItems menjadi orderDetails
     * agar selaras dengan pemanggilan ->load('orderDetails.product') di controller pengantaran
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Relasi Cadangan / Alias (Opsional): Jaga-jaga jika ada halaman lama customer 
     * yang telanjur memanggil ->orderItems agar tidak ikut rusak
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Relasi ke Payment: Satu transaksi pesanan memiliki satu rincian data pembayaran transfer
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}