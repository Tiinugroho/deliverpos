<?php

namespace database\seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // === KATEGORI 1: MAKANAN ===
        $kategoriMakanan = Category::create([
            'category_name' => 'Makanan Utama',
            'slug' => Str::slug('Makanan Utama'),
            'description' => 'Menu makanan berat harian atau porsi katering',
        ]);

        // Produk untuk Makanan
        Product::create([
            'category_id' => $kategoriMakanan->id,
            'product_name' => 'Nasi Kotak Ayam Bakar',
            'description' => 'Nasi, ayam bakar, sambal, lalapan, dan tahu tempe.',
            'stock' => 100,
            'price' => 25000.00,
            'image' => 'ayam_bakar.jpg', // Nama file dummy
        ]);

        Product::create([
            'category_id' => $kategoriMakanan->id,
            'product_name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan telur mata sapi dan sosis.',
            'stock' => 50,
            'price' => 20000.00,
            'image' => 'nasgor.jpg',
        ]);


        // === KATEGORI 2: MINUMAN ===
        $kategoriMinuman = Category::create([
            'category_name' => 'Minuman',
            'slug' => Str::slug('Minuman'),
            'description' => 'Aneka minuman segar dan hangat',
        ]);

        // Produk untuk Minuman
        Product::create([
            'category_id' => $kategoriMinuman->id,
            'product_name' => 'Es Teh Manis',
            'description' => 'Es teh manis segar ukuran jumbo.',
            'stock' => 200,
            'price' => 5000.00,
            'image' => 'es_teh.jpg',
        ]);

        Product::create([
            'category_id' => $kategoriMinuman->id,
            'product_name' => 'Jus Alpukat',
            'description' => 'Jus alpukat murni dengan topping susu cokelat.',
            'stock' => 30,
            'price' => 15000.00,
            'image' => 'jus_alpukat.jpg',
        ]);
    }
}