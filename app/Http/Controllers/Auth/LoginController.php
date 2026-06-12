<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna masuk ke sistem.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Proses pencocokan data login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Ambil data user yang berhasil login
            $user = Auth::user();

            // PERBAIKAN: Menambahkan pesan sukses beserta nama user yang sedang login
            if ($user->role === 'admin' || $user->role === 'cashier') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
            }

            // Jika role-nya customer / pelanggan biasa
            return redirect()->route('customer.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        // Jika gagal login, kembalikan dengan pesan error meluncur ke form
        return back()->withErrors([
            'email' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Proses keluar dari sistem (Logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tambahan: Memberikan toastr notifikasi sukses saat user berhasil keluar
        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}