<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'description',
        'stock',
        'price',
        'image',
    ];

    // Relasi ke Kategori: Produk ini termasuk dalam kategori apa
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}