<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman form pendaftaran (Kemitraan Baru).
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses pendaftaran user baru ke database.
     */
    public function register(Request $request)
    {
        // Validasi input form (disesuaikan dengan kolom tabel users di .sql Anda)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);

        // Create user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password aman
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => 'customer', // OTOMATIS DISET SEBAGAI CUSTOMER
        ]);

        // Otomatis login setelah berhasil mendaftar
        Auth::login($user);

        // PERBAIKAN: Mengubah ucapan selamat datang agar memanggil nama asli pendaftar baru
        return redirect()->route('customer.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }
}