<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📦 Sistem Manajemen Pesanan dan Pengantaran Digital

Aplikasi operasional katering berskala modern yang dirancang untuk mengotomatisasi manajemen alur pesanan katering dan orkestrasi pelacakan pengantaran secara terintegrasi. Proyek ini dibangun dengan fondasi **Laravel 12**, **Vite**, **Tailwind CSS v4**, dan **Alpine.js**.

---

## 🛠️ Prasyarat & Spesifikasi Ekosistem Proyek

Sebelum memulai proses instalasi, pastikan lingkungan lokal Anda telah memenuhi spesifikasi berikut:
* **PHP:** `^8.2`
* **Laravel Framework:** `^12.0`
* **Tailwind CSS:** `^4.0.0`
* **Vite:** `^6.0.11`
* **Database Default:** SQLite (otomatis dikonfigurasi oleh skrip proyek)

---

## 🚀 Panduan Langkah Instalasi Proyek

Ikuti rangkaian instruksi di bawah ini untuk melakukan setup dan menyalakan aplikasi di lingkungan lokal:

### 1. Kloning Repositori
git clone <url-repositori-kamu>
cd <nama-folder-proyek>

### 2. Instal Dependensi Composer (Backend PHP)
composer install

### 3. Duplikasi Berkas Environment Konfigurasi
cp .env.example .env

### 4. Generate Kunci Keamanan Aplikasi
php artisan key:generate

### 5. Eksekusi Migrasi Database & Pengisian Data Awal (Seeds)
Perintah ini akan menyusun skema tabel relasional dan memasukkan data akun simulasi peran (Customer, Admin, dan Staff):

php artisan migrate --seed

(Sistem secara otomatis membuat berkas basis data kosong database/database.sqlite jika Anda memakai driver default).

### 6. Instal Dependensi Node Package Manager (Frontend Assets)
npm install

💻 Menjalankan Aplikasi
Proyek ini memanfaatkan paket concurrently untuk menyatukan jalannya server internal backend, pemantau antrean (queue listen), log sitem, dan kompilator frontend Vite. Cukup jalankan satu baris perintah ini di terminal Anda:

composer run dev

Setelah proses inisiasi selesai, buka browser Anda dan akses alamat lokal:

Aplikasi Utama: http://127.0.0.1:8000

⚙️ 1. Overview Arsitektur Aplikasi (MVC Pattern)
Sistem backend mengadopsi standar arsitektur bersih berbasis MVC (Model-View-Controller) Laravel:


[HTTP Request] ──> ROUTES (routes/web.php) 
                        │ (Validasi rute & penapisan middleware)
                        ▼
                  CONTROLLERS (app/Http/Controllers/)
                        │ (Pemrosesan logika bisnis & otorisasi data)
                        ├─> MODELS (app/Models/) ──> [Database Layer]
                        ▼
                  VIEWS (resources/views/ dengan Blade Engine & Tailwind CSS)


- Routes (routes/web.php): Gerbang utama pemrosesan HTTP request. Berfungsi memetakan URI endpoint, mengikat model secara implisit, serta memproteksi hak akses pengguna via pipeline Middleware.

- Controllers (app/Http/Controllers/): Sentralisasi logika bisnis aplikasi. Berfungsi menerima input payload, memvalidasi aturan kepemilikan resource, memicu interaksi Eloquent ORM, dan mengirim data ke kompilator tampilan.

- Models (app/Models/): Abstraksi representasi skema tabel database dan kardinalitas relasi data (seperti hubungan One-to-Many dari Order ke OrderItem atau One-to-One ke entitas Payment).

- Views (resources/views/): Penyajian antarmuka responsif pengguna menggunakan mesin templating Blade dan utilitas kelas styling Tailwind CSS v4.

👥 2. Pembagian Peran & Hak Akses (Role Isolation)

Sistem mengisolasi hak privasi data dan hak eksekusi fitur secara ketat ke dalam 3 tingkatan peran pengguna:

A. Customer (Pelanggan)

- Menjelajah katalog produk menu aktif.
- Menambah produk ke dalam keranjang belanja lokal.
- Inisiasi checkout & pembuatan entitas pesanan baru.
- Mengunggah berkas gambar bukti pembayaran transaksi.
- Melacak mutasi progres status pengantaran makanan.
- Membatalkan pesanan (khusus selama status operasional masih PENDING).

B. Admin / Owner (Pemilik Toko)

- Manajemen kategori dan menu produk katering secara penuh (CRUD).
- Monitoring seluruh riwayat transaksi order dari semua pelanggan.
- Otorisasi verifikasi data dan validasi konfirmasi bukti pembayaran masuk.
- Manajemen, pendaftaran, dan penugasan akun staf/kasir operasional.
- Akses dasbor laporan keuangan, grafik penjualan, dan total pendapatan (revenue).

C. Cashier / Staff (Staf Operasional)

- Memantau data transaksi pesanan masuk harian.
- Memperbarui status progres pengerjaan order (dapur/toko).
- Memverifikasi bukti pembayaran fisik langsung.
- Manajemen pelacakan kurir (delivery tracking).
- ✕ Proteksi Keamanan: Peran ini dilarang melakukan CRUD pada data produk & kategori.


🔄 3. Alur Siklus Hidup Permintaan (User Journey)

A. Kondisi Sesi Guest (Belum Login)
Kunjungi Katalog Utama (/): Sistem menampilkan daftar menu katering aktif.

- Lihat Detail Menu (/products/{id}): Menampilkan rincian deskripsi spesifikasi produk beserta tombol Add to Cart.
- Buka Keranjang (/cart): Memodifikasi sediaan kuantitas item di keranjang belanja lokal.
- Klik Tombol Checkout: Sistem mendeteksi ketiadaan sesi aktif dan otomatis melemparkan (redirect) paksa ke halaman /login.

B. Kondisi Sesi Terotentikasi (Customer)

- Checkout (/checkout - POST): Validasi stok produk $\rightarrow$ Create record Order $\rightarrow$ Create detail OrderItem $\rightarrow$ Potong kuantitas stok produk $\rightarrow$ Redirect ke formulir pembayaran.
- Formulir Pembayaran (/order/{id}/payment - GET): Menampilkan ringkasan informasi total harga nota dan instruksi nomor rekening transfer bank.
- Upload Bukti Pembayaran (/order/{id}/payment - POST): Mengunggah file bukti transfer $\rightarrow$ Create record Payment $\rightarrow$ Update status order menjadi confirmed $\rightarrow$ Redirect ke riwayat pesanan.
- Detail Informasi Pesanan (/customer/orders/{id}): Fokus penampilan visual status progres pesanan, detail item makanan, data kurir pengantar, dan bukti bayar terlampir.

⭐ 4. Flow Detail: Customer Order Detail Page

🔄 Alur Eksekusi Pipeline Data (Step-by-Step)
Step 1: Inisiasi Permintaan HTTP
User menekan tautan riwayat pesanan. Browser mengirimkan HTTP request dengan method GET ke skema URL: /customer/orders/{order_id}.

Step 2: Pencocokan Jalur Rute
Router pada berkas routes/web.php mencocokkan pola URI di dalam grup rute terproteksi:

<p> Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/orders/{order}', [CustomerOrderController::class, 'detail'])->name('customer.orders.detail');
}); </p>

Step 3: Penyaringan Lapisan Middleware
Request disaring melewati dua lapis filter: middleware auth menguji validitas sesi login, dilanjutkan middleware kustom role:customer untuk menolak akses peran non-customer. Kegagalan validasi memicu interupsi status 403 Forbidden.

Step 4: Eksekusi Fungsi Controller & Proteksi Kepemilikan
Laravel mengonversi parameter {order} menjadi instance objek model secara otomatis (Implicit Route Binding). Fungsi handler pada CustomerOrderController@detail mengeksekusi logika berikut:

<p>
public function detail(Order $order)
{
    // 1. Proteksi Otorisasi Resource: Validasi kepemilikan data pesanan
    if ($order->user_id !== auth()->id()) { 
        abort(403); 
    }

    // 2. Eager Load Hubungan: Mengeliminasi fenomena N+1 query problem
    $order->load(['orderItems.product', 'payment']);

    // 3. Injeksi Atribut Tambahan Dinamis untuk View Layer
    $order->order_code = $order->order_number;
    if ($order->payment) {
        $order->payment->proof_image = $order->payment->proof_of_payment;
    }

    return view('customer.orders.detail', compact('order'));
}
</p>

Step 5: Pipeline Eksekusi Database SQL
Melalui instruksi penyiapan data load(), Laravel mengeksekusi 4 runtutan query database terstruktur di latar belakang secara efisien:

<p>
SELECT * FROM orders WHERE id = {id};
SELECT * FROM order_items WHERE order_id = {id};
SELECT * FROM products WHERE id IN (...);
SELECT * FROM payments WHERE order_id = {id};
</p>

Step 6 & 7: Rendering Tampilan HTML Kompilator
Mesin Blade memproses berkas template resources/views/customer/orders/detail.blade.php, menginjeksikan data objek $order, merendernya bersama aset Tailwind CSS v4 dan fungsionalitas interaktif Alpine.js, lalu menyajikannya ke layar antarmuka pengguna browser.

📊 5. Skema Hubungan Data Relasional (ERD)
Arsitektur basis data diikat oleh integritas referensial yang kokoh antarentitas model data:


User (users table)
    │
    └─► 1 : Many ──────────────► Order (orders table)
                                     │
                                     ├─► 1 : Many ──────► OrderItem (order_items)
                                     │                           │
                                     │                           └─► Many : 1 ───► Product
                                     │
                                     └─► 1 : 1 ─────────► Payment (payments)


Penulisan Relasi pada Model Utama (app/Models/Order.php)

<p>
class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'order_date', 
        'shipping_address', 'note', 'total_price', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
</p>

📋 6. Siklus Hidup Status Pesanan (Order Lifecycle)
Mutasi status data dikunci secara linier mengikuti kondisi riil pengerjaan pesanan dan proses pengantaran kurir di lapangan:


[ PENDING ] ───(Upload Bukti & Verifikasi Admin)───> [ CONFIRMED ]
     │                                                     │
     │ (Jalur Pembatalan Mandiri Customer)                 │ (Penugasan Kurir Pengantar)
     ▼                                                     ▼
[ CANCELLED ]                                        [ ON_DELIVERY ]
(Kuantitas stok produk                                     │
 dikembalikan ke inventori)                                │ (Pesanan Tiba & Diterima)
                                                           ▼
                                                     [ COMPLETED ]


🔒 7. Keamanan & Proteksi Lapisan Akses (3-Layer Security)
Sistem ini menerapkan arsitektur keamanan tiga lapis guna mencegah celah kerentanan data bocor (Insecure Direct Object Reference / IDOR):

- Lapis 1 (Authentication Filter): Menggunakan middleware bawaan auth untuk memastikan hanya pengguna terdaftar dengan sesi login aktif yang dapat memuat endpoint rute internal.

- Lapis 2 (Role Authorization Filter): Menggunakan pengujian gerbang middleware role:customer untuk menjamin area operasional pelanggan tidak disalahgunakan oleh level akun peran lain.

- Lapis 3 (Resource Ownership Validation): Validasi logika internal di level fungsi controller dengan membandingkan kecocokan variabel: if ($order->user_id !== auth()->id()) { abort(403); }. Hal ini mengunci keamanan data sehingga pengguna dilarang keras mengintip nota pesanan milik pengguna lain dengan cara menebak-nebak manipulasi variabel parameter ID pada URL.

📑 8. Pemetaan Registrasi Endpoint Sistem
Berikut daftar pemetaan rute operasional formal yang merekatkan seluruh modul sistem antarmuka pesanan:

Fitur Operasional	      │ Endpoint URL	            │ HTTP Method  │Nama Rute (Route Name)	 │Target Controller Method
Daftar Riwayat Transaksi  │	/customer/orders	        │ GET	       │customer.orders	         │ CustomerOrderController@index
Halaman Detail Informasi  │	/customer/orders/{id}	    │ GET	       │customer.orders.detail	 │ CustomerOrderController@detail
Pembatalan Progres Pesanan│	/customer/orders/{id}/cancel│ PUT	       │customer.orders.cancel	 │ CustomerOrderController@cancel
Formulir Upload Lampiran  │	/order/{id}/payment	        │ GET	       │customer.payment.form	 │ CustomerOrderController@paymentForm
Pemrosesan File Pembayaran│	/order/{id}/payment	        │ POST         │customer.payment.store	 │ CustomerOrderController@storePayment
Dasbor Utama Ringkasan	  │ /customer/dashboard	        │ GET	       │customer.dashboard       │ CustomerDashboardController@index

📚 9. Tentang Laravel Framework (Dokumentasi Resmi)
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

Simple, fast routing engine.

Powerful dependency injection container.

Multiple back-ends for session and cache storage.

Expressive, intuitive database ORM.

Database agnostic schema migrations.

Robust background job processing.

Real-time event broadcasting.  

Learning Laravel
Laravel has the most extensive and thorough documentation and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.  

You may also try the Laravel Bootcamp, where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, Laracasts can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

License
  
The Laravel framework is open-sourced software licensed under the MIT license.