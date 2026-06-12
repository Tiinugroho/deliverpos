<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Mengambil semua order diurutkan dari yang terbaru
        $orders = Order::with('user')->orderBy('order_date', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Memuat item produk pesanan dan bukti pembayarannya
        $order->load(['user', 'orderItems.product', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,on_delivery,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        // Berikan teks notifikasi cerdas berdasarkan status operasional terbaru
        $notification = 'Status operasional pesanan berhasil diperbarui.';
        if ($request->status === 'on_delivery') {
            $notification = 'Pesanan #' . $order->order_number . ' sukses dialihkan ke kurir dan sedang dalam perjalanan!';
        } elseif ($request->status === 'completed') {
            $notification = 'Selesai! Pesanan #' . $order->order_number . ' telah sukses diterima oleh pelanggan.';
        }

        return redirect()->back()->with('success', $notification);
    }

    // 1. METHOD: MENAMPILKAN DAFTAR UTAMA PENGANTARAN
    public function deliveryIndex()
    {
        $deliveries = Order::whereIn('status', ['on_delivery'])
            ->orderBy('order_date', 'desc')
            ->get();

        return view('admin.deliveries.index', compact('deliveries'));
    }

    // 2. METHOD BARU: MENAMPILKAN DETAIL PESANAN YANG AKAN DIANTAR
    public function deliveryShow(Order $order)
    {
        // Memastikan staf tidak bisa mengintip detail orderan yang statusnya masih pending/cancelled
        if (!in_array($order->status, ['on_delivery', 'completed'])) {
            return redirect()->route('admin.deliveries.index')->with('error', 'Data pengantaran tidak ditemukan atau belum siap.');
        }

        // Me-load relasi item produk di dalam orderan tersebut
        $order->load('orderDetails.product');

        return view('admin.deliveries.show', compact('order'));
    }

    // 3. METHOD: PROSES UBAH STATUS KIRIMAN
    public function updateDeliveryStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:on_delivery,completed',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        $message = $request->status === 'on_delivery' ? 'Pesanan #' . $order->order_number . ' berhasil dilepas! Kurir sedang di perjalanan.' : 'Alhamdulillah, pesanan #' . $order->order_number . ' telah sukses sampai ke tujuan!';

        // Jika sudah selesai, kembalikan ke halaman utama pengantaran, jika baru berangkat tetap di halaman detail
        if ($request->status === 'completed') {
            return redirect()->route('admin.deliveries.index')->with('success', $message);
        }

        return redirect()->back()->with('success', $message);
    }
}
