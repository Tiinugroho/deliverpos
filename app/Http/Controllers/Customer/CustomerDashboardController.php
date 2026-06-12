<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Penghitungan kalkulasi data widget
        $totalBelanja = Order::where('user_id', $userId)->where('status', 'completed')->sum('total_price');
        $pesananPending = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $pesananDiproses = Order::where('user_id', $userId)->whereIn('status', ['confirmed', 'on_delivery'])->count();

        // Mengambil 5 rincian transaksi terakhir milik pelanggan tersebut
        $recentOrders = Order::where('user_id', $userId)->orderBy('order_date', 'desc')->take(5)->get();

        // Aliasing agar variable $order->order_code di baris table terhindar dari nilai kosong/null
        foreach ($recentOrders as $order) {
            $order->order_code = $order->order_number;
        }

        return view('customer.dashboard', compact('totalBelanja', 'pesananPending', 'pesananDiproses', 'recentOrders'));
    }

    public function passwordForm()
    {
        return view('customer.password');
    }

    // 2. METHOD BARU: MEMPROSES PERUBAHAN PASSWORD BARU
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed', // password baru wajib min 8 karakter dan match dengan konfirmasi
        ]);

        $user = auth()->user();

        // VALIDASI KEAMANAN: Cek apakah password lama yang diinput cocok dengan di database
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi lama yang Anda masukkan tidak cocok.');
        }

        // Simpan password baru setelah di-enkripsi (Hash)
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Kata sandi akun Anda berhasil diperbarui!');
    }
}