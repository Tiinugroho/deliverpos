<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// ROUTE UMUM / PUBLIC (BISA DIAKSES SIAPAPUN TANPA LOGIN)
// =========================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route Autentikasi (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// =========================================================================
// ROUTE KHUSUS CUSTOMER / PELANGGAN
// =========================================================================
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/customer/orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/customer/orders/{order}', [CustomerOrderController::class, 'detail'])->name('customer.orders.detail');
    Route::put('/customer/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');
    
    Route::post('/checkout', [CustomerOrderController::class, 'checkout'])->name('checkout.store');
    Route::get('/order/{order}/payment', [CustomerOrderController::class, 'paymentForm'])->name('payment.form');
    Route::post('/order/{order}/payment', [CustomerOrderController::class, 'storePayment'])->name('payment.store');

    // --- FITUR GANTI/RESET PASSWORD MANDIRI OLEH CUSTOMER ---
    Route::get('/customer/password', [CustomerDashboardController::class, 'passwordForm'])->name('customer.password.edit');
    Route::put('/customer/password', [CustomerDashboardController::class, 'updatePassword'])->name('customer.password.update');
});


// =========================================================================
// ROUTE BERSAMA: BISA DIAKSES OLEH ADMIN (OWNER) MAUPUN CASHIER (STAFF)
// =========================================================================
Route::middleware(['auth', 'role:admin,cashier'])->group(function () {
    
    // Halaman Utama Dashboard Admin/Kasir
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // Manajemen Operasional Pesanan (Orders)
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

    // Manajemen Operasional Verifikasi Pembayaran (Payments)
    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/admin/payments/{payment}', [AdminPaymentController::class, 'show'])->name('admin.payments.show');
    Route::put('/admin/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('admin.payments.verify');

    // --- MANAJEMEN PENGANTARAN INTERNAL STAF (Deliveries) ---
    Route::get('/admin/deliveries', [AdminOrderController::class, 'deliveryIndex'])->name('admin.deliveries.index');
    Route::get('/admin/deliveries/{order}', [AdminOrderController::class, 'deliveryShow'])->name('admin.deliveries.show');
    Route::put('/admin/deliveries/{order}/status', [AdminOrderController::class, 'updateDeliveryStatus'])->name('admin.deliveries.update');
});


// =========================================================================
// LOCK MUTLAK: HANYA BOLEH DIAKSES OLEH ROLE ADMIN (OWNER) SAJA
// =========================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // --- KELOLA KATEGORI (Categories) ---
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // --- KELOLA PRODUK / MENU (Products) ---
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // --- KELOLA KARYAWAN / PEGAWAI / KASIR (Staff) ---
    Route::get('/admin/staff', [StaffController::class, 'index'])->name('admin.staff.index');
    Route::get('/admin/staff/create', [StaffController::class, 'create'])->name('admin.staff.create');
    Route::post('/admin/staff', [StaffController::class, 'store'])->name('admin.staff.store');
    Route::get('/admin/staff/{staff}', [StaffController::class, 'show'])->name('admin.staff.show');
    Route::get('/admin/staff/{staff}/edit', [StaffController::class, 'edit'])->name('admin.staff.edit');
    Route::put('/admin/staff/{staff}', [StaffController::class, 'update'])->name('admin.staff.update');
    Route::delete('/admin/staff/{staff}', [StaffController::class, 'destroy'])->name('admin.staff.destroy');

    // --- KELOLA DATA PELANGGAN (Customers) ---
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
    Route::put('/admin/customers/{customer}/reset-password', [CustomerController::class, 'resetPassword'])->name('admin.customers.reset');

    // --- LAPORAN TRANSAKSI FINANSIAL (Reports) ---
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
});