<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda utama / landing page.
     */
    public function index()
    {
        // Mengambil 4 produk terbaru dari database untuk ditampilkan di bagian "Komoditas Produk Terkini"
        // Menggunakan with('category') untuk menghindari masalah N+1 query
        $featuredProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Mengembalikan file view blade Anda (asumsi disimpan di resources/views/home.blade.php)
        return view('home', compact('featuredProducts'));
    }
}