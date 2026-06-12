<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Payment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Berbagi data counter ke seluruh file views admin secara global
        View::composer('*', function ($view) {
            
            // 1. PESANAN MASUK: Menghitung status pending DAN confirmed menggunakan whereIn
            $view->with('pendingOrdersCount', Order::whereIn('status', ['pending', 'confirmed'])->count());
            
            // 2. CEK PEMBAYARAN: Menghitung bukti transfer yang belum diverifikasi
            $view->with('unverifiedPaymentsCount', Payment::where('status', 'unverified')->count());
            
            // 3. PENGANTARAN TOKO: Hanya menghitung pesanan yang posisinya sedang berada di perjalanan
            $view->with('activeDeliveriesCount', Order::whereIn('status', ['on_delivery'])->count());
            
        });
    }
}