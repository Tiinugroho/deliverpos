<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 1. MENAMPILKAN HALAMAN LAPORAN TRANSAKSI
    public function index(Request $request)
    {
        // Membuat query dasar untuk order yang sukses / selesai diantar
        $query = Order::where('status', 'completed')->with('user');

        // Fitur Tambahan: Filter rentang tanggal jika admin memilih tanggal tertentu
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('order_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Ambil semua data sesuai filter di atas
        $completedOrders = $query->orderBy('order_date', 'desc')->get();

        // Menghitung ringkasan total (akumulasi) penjualan untuk statistik report
        $totalRevenue = $completedOrders->sum('total_price'); // Total Uang Masuk
        $totalTransactions = $completedOrders->count();      // Total Nota Selesai

        return view('admin.reports.index', compact('completedOrders', 'totalRevenue', 'totalTransactions'));
    }
}