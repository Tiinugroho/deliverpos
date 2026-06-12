<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // 1. MENAMPILKAN DAFTAR KARYAWAN (Hanya yang role-nya admin atau cashier)
    public function index()
    {
        // Mengambil data user yang merupakan admin atau cashier
        $staffs = User::whereIn('role', ['admin', 'cashier'])
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.staff.index', compact('staffs'));
    }

    // 2. MENAMPILKAN FORM TAMBAH KARYAWAN
    public function create()
    {
        return view('admin.staff.create');
    }

    // 3. MENYIMPAN DATA KARYAWAN BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Menyimpan data ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-enkripsi
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => 'cashier', // OTOMATIS: Default role terkunci sebagai kasir / staff
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Akun karyawan baru berhasil didaftarkan!');
    }

    // 4. MENAMPILKAN DETAIL KARYAWAN
    public function show(User $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    // 5. MENAMPILKAN FORM EDIT KARYAWAN
    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    // 6. MENYIMPAN PERUBAHAN DATA KARYAWAN
    // KODE PERBAIKAN: MENYIMPAN PERUBAHAN DATA KARYAWAN
    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            // Validasi role dihapus dari sini karena form sudah di-disabled/lock
        ]);

        // Update data teks umum
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->phone_number = $request->phone_number;
        $staff->address = $request->address;
        // $staff->role tidak ikut diubah agar tetap sesuai data awal di database

        // Jika password diisi baru, maka update
        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->save();

        return redirect()->route('admin.staff.index')->with('success', 'Data akun karyawan berhasil diperbarui!');
    }

    // 7. MENGHAPUS AKUN KARYAWAN
    public function destroy(User $staff)
    {
        // Mencegah admin menghapus dirinya sendiri secara tidak sengaja
        if (auth()->id() === $staff->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif.');
        }

        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
