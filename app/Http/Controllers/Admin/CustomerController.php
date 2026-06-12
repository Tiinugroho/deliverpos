<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // 1. MENAMPILKAN DAFTAR PELANGGAN / CUSTOMER
    public function index()
    {
        // Hanya mengambil user yang murni memiliki role 'customer'
        $customers = User::where('role', 'customer')->orderBy('created_at', 'desc')->get();
        return view('admin.customers.index', compact('customers'));
    }

    // 2. FITUR BARU: RESET PASSWORD PELANGGAN (Kembali ke Password Bawaan)
    public function resetPassword(Request $request, User $customer)
    {
        // Mengubah password pelanggan menjadi default: 'pelanggan123'
        $customer->update([
            'password' => Hash::make('pelanggan123') // Di-hash ulang agar aman di database
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Password untuk pelanggan ' . $customer->name . ' berhasil di-reset menjadi: pelanggan123');
    }

    // 3. MENGHAPUS DATA PELANGGAN
    public function destroy(User $customer)
    {
        // Menghapus data pelanggan dari database
        $customer->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', 'Data akun pelanggan berhasil dihapus dari sistem.');
    }
}