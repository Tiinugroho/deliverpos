<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung total user dengan role customer
        $totalCustomers = User::where('role', 'customer')->count();

        // 2. Menghitung total orderan yang masuk hari ini
        $ordersToday = Order::whereDate('order_date', Carbon::today())->count();

        // 3. Menghitung akumulasi pendapatan dari orderan yang berstatus 'completed'
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');

        // 4. Menghitung jumlah bukti transfer yang berstatus 'unverified'
        $pendingVerification = Payment::where('status', 'unverified')->count();

        // 5. Mengambil 5 pesanan terbaru lengkap dengan data user dan pembayarannya
        $recentOrders = Order::with(['user', 'payment'])
            ->where('status', '!=', 'completed') // Opsional: hanya tampilkan order yang tidak dibatalkan
            ->orderBy('order_date', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'ordersToday',
            'totalRevenue',
            'pendingVerification',
            'recentOrders'
        ));
    }
}