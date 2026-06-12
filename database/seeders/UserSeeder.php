<?php

namespace database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin (Owner sekaligus Driver)
        User::create([
            'name' => 'Ahmad Owner (Admin)',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Password untuk login
            'phone_number' => '081234567890',
            'address' => 'Jl. Utama No. 1, Pekanbaru',
            'role' => 'admin',
        ]);

        // 2. Akun Kasir (Karyawan Toko)
        User::create([
            'name' => 'Siti Kasir',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('password123'),
            'phone_number' => '081298765432',
            'address' => 'Jl. Subrantas No. 45, Pekanbaru',
            'role' => 'cashier',
        ]);

        // 3. Akun Customer (Contoh Pelanggan)
        User::create([
            'name' => 'Budi Pelanggan',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password123'),
            'phone_number' => '085311223344',
            'address' => 'Perumahan Indah Blok C, Pekanbaru',
            'role' => 'customer',
        ]);
    }
}