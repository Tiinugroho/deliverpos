# 📋 Dokumentasi Flow Sistem DIO App (Catering Order System)

## 1️⃣ Overview Arsitektur Aplikasi

```
┌────────────────────────────────────────────────────────────────────┐
│                       DIO APP ARCHITECTURE                         │
├────────────────────────────────────────────────────────────────────┤
│                                                                    │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │  ROUTES (routes/web.php)                                     │  │
│  │  - Mendefinisikan semua endpoint URL aplikasi                │  │
│  │  - Mapping URL ke Controller & Method                        │  │
│  │  - Middleware: auth, role:customer, role:admin               │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                          ↓                                         │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │  CONTROLLERS (app/Http/Controllers/)                         │  │
│  │  - Handle business logic & request processing                │  │
│  │  - Interact dengan Models                                    │  │
│  │  - Return responses (view/redirect/JSON)                     │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                          ↓                                         │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │  MODELS (app/Models/)                                        │  │
│  │  - Represent database tables                                 │  │
│  │  - Define relationships antar model                          │  │
│  │  - Business logic level database                             │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                          ↓                                         │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │  VIEWS (resources/views/)                                    │  │
│  │  - Blade templates untuk UI                                  │  │
│  │  - Display data dari controller                              │  │
│  │  - Tailwind CSS untuk styling                                │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                                                                    │
└────────────────────────────────────────────────────────────────────┘
```

---

## 2️⃣ Pembagian Role & Akses

```
┌──────────────────────────────────────────────────────────────┐
│  CUSTOMER (Pelanggan)                                        │
├──────────────────────────────────────────────────────────────┤
│  • Browse produk & lihat katalog menu                        │
│  • Menambah produk ke keranjang                              │
│  • Checkout & membuat pesanan                                │
│  • Upload bukti pembayaran                                   │
│  • Melihat riwayat pesanan & detail pesanan                  │
│  • Melacak status pengiriman pesanan                         │
│  • Membatalkan pesanan (jika masih pending)                  │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│  ADMIN / OWNER (Pemilik Toko)                                │
├──────────────────────────────────────────────────────────────┤
│  • Kelola kategori produk                                    │
│  • Kelola produk/menu (CRUD)                                 │
│  • Lihat semua pesanan customer                              │
│  • Update status pesanan (pending → confirmed → ...)         │
│  • Verifikasi bukti pembayaran customer                      │
│  • Manajemen staff/kasir                                     │
│  • Lihat laporan penjualan & revenue                         │
│  • Kelola pengiriman pesanan                                 │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│  CASHIER / STAFF (Kasir/Staff Toko)                          │
├──────────────────────────────────────────────────────────────┤
│  • Lihat semua pesanan customer                              │
│  • Update status pesanan                                     │
│  • Verifikasi bukti pembayaran customer                      │
│  • Kelola pengiriman pesanan (delivery tracking)             │
│  └ Tidak bisa kelola kategori & produk                       │
└──────────────────────────────────────────────────────────────┘
```

---

## 3️⃣ Flow Umum Aplikasi (User Journey)

```
  ┌────────────────────────────────────────────────────────────┐
  │                  USER TIDAK LOGIN                          │
  ├────────────────────────────────────────────────────────────┤
  │                                                            │
  │   1. Kunjungi Home (/)                                     │
  │      └─→ Display katalog produk                            │
  │                                                            │
  │   2. Lihat Detail Produk (/products/{id})                  │
  │      └─→ Display info produk & add to cart button          │
  │                                                            │
  │   3. Buka Cart (/cart)                                     │
  │      └─→ Display items di keranjang                        │
  │                                                            │
  │   4. Klik Checkout → Redirect ke Login                     │
  │                                                            │
  └────────────────────────────────────────────────────────────┘
                           ↓ LOGIN
  ┌────────────────────────────────────────────────────────────┐
  │               USER SUDAH LOGIN (CUSTOMER)                  │
  ├────────────────────────────────────────────────────────────┤
  │                                                            │
  │   1. Checkout (/checkout - POST)                           │
  │      • Validasi cart items & shipping address              │
  │      • Create Order record                                 │
  │      • Create OrderItems untuk setiap item                 │
  │      • Deduct stock produk                                 │
  │      └─→ Redirect ke payment form                          │
  │                                                            │
  │   2. Lihat Form Pembayaran (/order/{id}/payment)           │
  │      • Display order info & total harga                    │
  │      └─→ Customer upload bukti pembayaran                  │
  │                                                            │
  │   3. Upload Bukti Pembayaran (/order/{id}/payment - POST)  │
  │      • Store file bukti pembayaran                         │
  │      • Create Payment record                               │
  │      • Update Order status → confirmed                     │
  │      └─→ Redirect ke riwayat pesanan                       │
  │                                                            │
  │   4. Dashboard Customer (/customer/dashboard)              │
  │      └─→ Display overview akun & pesanan                   │
  │                                                            │
  │   5. Riwayat Pesanan (/customer/orders)                    │
  │      └─→ Display list semua pesanan user                   │
  │                                                            │
  │   6. Detail Pesanan (/customer/orders/{id})  FOKUS         │
  │      └─→ Display info lengkap pesanan (status, items,      │
  │           bukti pembayaran, tracking, dsb)                 │
  │                                                            │
  │   7. Batalkan Pesanan (jika pending)                       │
  │      └─→ Cancel order & return stok produk                 │
  │                                                            │
  └────────────────────────────────────────────────────────────┘
```

---

## 4️⃣ FLOW DETAIL: Customer Order Detail Page ⭐

### 📍 Alamat File
- **Route**: `routes/web.php`
- **View**: `resources/views/customer/orders/detail.blade.php`
- **Controller**: `app/Http/Controllers/Customer/CustomerOrderController.php`
- **Models**: `Order`, `OrderItem`, `Product`, `Payment`, `User`

### 🔄 Execution Flow

```
┌─────────────────────────────────────────────────────────────────┐
│  STEP 1: USER KLIK LINK DETAIL PESANAN                          │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  URL: /customer/orders/{order_id}                               │
│  Method: GET                                                    │
│  Contoh: /customer/orders/5                                     │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│  STEP 2: ROUTE DISPATCHER CARI ROUTE YANG SESUAI                │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  File: routes/web.php                                           │
│  ────────────────────────────────────────────────────────────   │
│                                                                 │
│  Route::middleware(['auth', 'role:customer'])->group(function(){│
│    Route::get(                                                  │
│      '/customer/orders/{order}',                                │
│      [CustomerOrderController::class, 'detail']                 │
│    )->name('customer.orders.detail');                           │
│  });                                                            │
│                                                                 │
│  COCOK → Forward ke Controller                                  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│  STEP 3: VERIFIKASI MIDDLEWARE                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Middleware 1: auth                                             │
│  • Cek apakah user sudah login?                                 │
│  • Jika tidak → redirect ke /login                              │
│                                                                 │
│  Middleware 2: role:customer                                    │
│  • Cek apakah user punya role 'customer'?                       │
│  • Jika tidak → abort 403 (Forbidden)                           │
│                                                                 │
│  LOLOS → Lanjut ke Controller                                   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│  STEP 4: JALANKAN CONTROLLER METHOD                             │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Class: CustomerOrderController                                 │
│  Method: detail($order)                                         │
│                                                                 │
│  File: app/Http/Controllers/Customer/CustomerOrderController.php│
│                                                                 │
│  protected $model = Order::class (implicit route binding)       │
│  Laravel otomatis konversi {order} ke Order model               │
│                                                                 │
│  ────────────────────────────────────────────────────────────   │
│  public function detail(Order $order)                           │
│  {                                                              │
│      // Authorization check: pastikan order ini milik user      │
│      if ($order->user_id !== auth()->id()) {                    │
│          abort(403); // Forbidden                               │
│      }                                                          │
│                                                                 │
│      // Load relations: eager loading untuk avoid N+1           │
│      $order->load(['orderItems.product', 'payment']);           │
│                                                                 │
│      // Set additional properties untuk view                    │
│      $order->order_code = $order->order_number;                 │
│      if ($order->payment) {                                     │
│          $order->payment->proof_image =                         │
│              $order->payment->proof_of_payment;                 │
│      }                                                          │
│                                                                 │
│      // Return view dengan data order                           │
│      return view('customer.orders.detail', compact('order'));   │
│  }                                                              │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│  STEP 5: FETCH DATA DARI DATABASE                               │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Controller memanggil:                                          │
│  $order->load(['orderItems.product', 'payment'])                │
│                                                                 │
│  Query 1: SELECT * FROM orders WHERE id = {id}                  │
│  └─→ Get Order data                                             │
│                                                                 │
│  Query 2: SELECT * FROM order_items WHERE order_id = {id}       │
│  └─→ Get semua items dalam pesanan                              │
│                                                                 │
│  Query 3: SELECT * FROM products WHERE id IN (...)              │
│  └─→ Get data produk untuk setiap item                          │
│      (name, price, image, dsb)                                  │
│                                                                 │
│  Query 4: SELECT * FROM payments WHERE order_id = {id}          │
│  └─→ Get data pembayaran (if exists)                            │
│      (amount, method, proof, status)                            │
│                                                                 │
│  Data ready → Pass ke View                                      │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│  STEP 6: RENDER VIEW (BLADE TEMPLATE)                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  File: resources/views/customer/orders/detail.blade.php         │
│                                                                 │
│  Laravel Blade Engine:                                          │
│  • Parse template file                                          │
│  • Inject variables dari controller ($order)                    │
│  • Render conditional logic (@if, @foreach, dsb)                │
│  • Compile menjadi HTML                                         │
│                                                                 │
│  Template menampilkan:                                          │
│  ✓ Breadcrumb back link                                         │
│  ✓ Order status progress bar                                    │
│  ✓ Order number & date                                          │
│  ✓ Shipping address                                             │
│  ✓ List items yang dibeli (daftar produk)                       │
│  ✓ Total harga                                                  │
│  ✓ Status pembayaran & bukti pembayaran                         │
│  ✓ Action buttons (batalkan, bayar ulang, dsb)                  │
│                                                                 │
│  HTML ready → Send ke browser                                   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
                             ↓
┌─────────────────────────────────────────────────────────────────┐
│  STEP 7: BROWSER RENDER HALAMAN DI UI                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Browser menerima HTML response                                 │
│  • Parse HTML structure                                         │
│  • Load CSS (Tailwind CSS dari CDN)                             │
│  • Load JS (Alpine.js untuk interactivity)                      │
│  • Render UI dengan styling                                     │
│  • Ready for user interaction                                   │
│                                                                 │
│  Halaman detail pesanan siap ditampilkan!                       │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 🏗️ Data Structure

```
ORDER OBJECT YANG DIKIRIM KE VIEW:
────────────────────────────────────────────────────────────────
{
  id: 1,
  order_number: "ORD-20260605034530-456",
  order_code: "ORD-20260605034530-456",
  user_id: 2,
  order_date: "2026-06-05 03:45:30",
  shipping_address: "Jl. Merdeka No. 123, Jakarta",
  note: "Jangan terlalu pedas",
  total_price: 250000,
  status: "confirmed",
  created_at: "2026-06-05 03:45:30",
  updated_at: "2026-06-05 04:20:15",
  
  // Relations (loaded via eager loading)
  orderItems: [
    {
      id: 1,
      order_id: 1,
      product_id: 5,
      quantity: 2,
      price_at_purchase: 50000,
      product: {
        id: 5,
        product_name: "Nasi Goreng Spesial",
        price: 50000,
        image: "product-5.jpg",
        stock: 45
      }
    },
    {
      id: 2,
      order_id: 1,
      product_id: 8,
      quantity: 3,
      price_at_purchase: 50000,
      product: {
        id: 8,
        product_name: "Soto Ayam",
        price: 50000,
        image: "product-8.jpg",
        stock: 30
      }
    }
  ],
  
  payment: {
    id: 1,
    order_id: 1,
    amount: 250000,
    payment_method: "bank_transfer",
    proof_of_payment: "PAY--1717547130.jpg",
    proof_image: "PAY--1717547130.jpg",
    status: "verified",
    created_at: "2026-06-05 04:20:15"
  }
}
```

---

## 5️⃣ Database Relationships

```
┌──────────────────────────────────────────────────────────────────┐
│                   ENTITY RELATIONSHIP DIAGRAM                    │
└──────────────────────────────────────────────────────────────────┘

User (users table)
  │
  ├─► 1 : Many ──────────────► Order (orders table)
  │                               │
  │                               ├─► 1 : Many ──────┐
  │                               │                   ▼
  │                               │            OrderItem (order_items)
  │                               │                   │
  │                               │                   ├─► M : 1 ──────► Product
  │                               │
  │                               └─► 1 : 1 ────────► Payment (payments)
  │
  └─(Other relationships)


TABEL USERS:
  id | name | email | password | role | ...
  1  | John | j@... | hash...  | customer

TABEL ORDERS:
  id | order_number          | user_id | order_date | shipping_address | note | total_price | status    | created_at
  1  | ORD-20260605034530-456| 1       | 2026-06-05 | Jl. Merdeka ...  | ...  | 250000      | confirmed | ...

TABEL ORDER_ITEMS:
  id | order_id | product_id | quantity | price_at_purchase
  1  | 1        | 5          | 2        | 50000
  2  | 1        | 8          | 3        | 50000

TABEL PRODUCTS:
  id | product_name          | category_id | price | stock | image | description
  5  | Nasi Goreng Spesial   | 1          | 50000 | 45    | ...   | ...
  8  | Soto Ayam             | 2          | 50000 | 30    | ...   | ...

TABEL PAYMENTS:
  id | order_id | amount | payment_method | proof_of_payment  | status   | created_at
  1  | 1        | 250000 | bank_transfer  | PAY--1717547130.jpg | verified | ...
```

---

## 6️⃣ Files & Kode yang Terlibat

### 📄 Route Definition
**File**: `routes/web.php` (Line ~42-43)
```php
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/orders/{order}', [CustomerOrderController::class, 'detail'])->name('customer.orders.detail');
});
```

### 🎮 Controller Method
**File**: `app/Http/Controllers/Customer/CustomerOrderController.php` (Line ~87-100)
```php
public function detail(Order $order)
{
    // 1. Authorization: pastikan order milik user yang login
    if ($order->user_id !== auth()->id()) { 
        abort(403); 
    }

    // 2. Eager load relations untuk avoid N+1 query problem
    $order->load(['orderItems.product', 'payment']);
    
    // 3. Set additional properties
    $order->order_code = $order->order_number;
    if ($order->payment) {
        $order->payment->proof_image = $order->payment->proof_of_payment;
    }

    // 4. Render view dengan pass data $order
    return view('customer.orders.detail', compact('order'));
}
```

### 📦 Model: Order
**File**: `app/Models/Order.php`
```php
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
```

### 📦 Model: OrderItem
**File**: `app/Models/OrderItem.php`
```php
class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price_at_purchase'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
```

### 📦 Model: Payment
**File**: `app/Models/Payment.php`
```php
class Payment extends Model
{
    protected $fillable = [
        'order_id', 'amount', 'payment_method', 
        'proof_of_payment', 'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
```

### 🎨 View: Blade Template
**File**: `resources/views/customer/orders/detail.blade.php`
```blade
@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="space-y-6 text-xs md:text-sm">
    
    <!-- Breadcrumb -->
    <div>
        <a href="{{ route('customer.orders') }}" class="...">
            Kembali ke Riwayat Pesanan
        </a>
    </div>

    <!-- Order Status Progress Bar -->
    <div class="glass-card bg-white rounded-3xl p-6 ...">
        <!-- Progress tracking dari pending → completed -->
    </div>

    <!-- Order Info & Shipping Address -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <p>Informasi Nota</p>
            <p>#{{ $order->order_number }}</p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</p>
        </div>
        <div>
            <p>Alamat Pengantaran</p>
            <p>{{ $order->shipping_address }}</p>
            <p>Catatan: {{ $order->note ?? 'Tidak ada catatan tambahan.' }}</p>
        </div>
    </div>

    <!-- Order Items Table -->
    <div class="bg-white rounded-xl ...">
        <table>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Payment Info -->
    @if($order->payment)
        <div class="bg-white rounded-xl ...">
            <h3>Bukti Pembayaran</h3>
            <img src="{{ asset('storage/payments/' . $order->payment->proof_image) }}" />
        </div>
    @endif

</div>
@endsection
```

---

## 7️⃣ Status Order & Lifecycle

```
┌────────────────────────────────────────────────────────┐
│           ORDER STATUS LIFECYCLE DIAGRAM               │
└────────────────────────────────────────────────────────┘

   ┌─────────────┐
   │   PENDING   │
   │(Menunggu    │
   │ Pembayaran) │
   └──────┬──────┘
          │
          │ Customer upload bukti pembayaran
          │ Admin verify bukti pembayaran
          ▼
   ┌─────────────────┐
   │  CONFIRMED      │
   │ (Pesanan       │
   │  Dikonfirmasi) │
   └──────┬──────────┘
          │
          │ Siap untuk dikirim
          │ Admin assign delivery
          ▼
   ┌──────────────────┐
   │  ON_DELIVERY     │
   │ (Sedang          │
   │  Diantar Driver) │
   └──────┬───────────┘
          │
          │ Driver antar & customer terima
          │ Mark as delivered
          ▼
   ┌──────────────────┐
   │   COMPLETED      │
   │ (Selesai /       │
   │  Diterima)       │
   └──────────────────┘


Alternative path (jika customer batalkan):
   
   PENDING ───→ CANCELLED
   (saat pending saja, jika sudah confirmed tidak bisa dibatalkan)
   
Aksi ketika batalkan:
   • Stock produk dikembalikan ke inventory
   • Order status = cancelled
   • Customer bisa lihat riwayat pesanan yang dibatalkan
```

---

## 8️⃣ Fitur Tambahan pada Detail Pesanan

```
┌─────────────────────────────────────────────────────────┐
│  FITUR YANG BISA DIAKSES DARI HALAMAN DETAIL           │
└─────────────────────────────────────────────────────────┘

1. Batalkan Pesanan (jika status = pending)
   Route: PUT /customer/orders/{order}/cancel
   ✓ Mengembalikan stok produk
   ✓ Update status → cancelled
   ✓ Redirect ke halaman riwayat pesanan

2. Upload Ulang Bukti Pembayaran (jika rejected)
   Route: GET /order/{order}/payment
   ✓ Redirect ke form payment ulang
   ✓ Customer bisa submit proof baru

3. Tracking Pengiriman (jika on_delivery)
   ✓ Display driver info
   ✓ Display estimated delivery time
   ✓ Real-time status updates

4. Download Invoice
   ✓ Export pesanan sebagai PDF (optional feature)
   
5. Hubungi Admin
   ✓ Chat atau contact form
   ✓ Untuk pertanyaan terkait pesanan
```

---

## 9️⃣ Middleware & Security

```
┌───────────────────────────────────────────────────────────┐
│              MIDDLEWARE PROTECTION LAYERS                 │
└───────────────────────────────────────────────────────────┘

1. AUTHENTICATION (auth)
   • Middleware: Illuminate\Auth\Middleware\Authenticate
   • Validasi: Apakah user sudah login?
   • Jika tidak: Redirect ke /login
   • ✓ Prevent unauthorized access

2. AUTHORIZATION (role:customer)
   • Middleware: Custom Role Middleware
   • Validasi: Apakah user punya role = 'customer'?
   • Jika tidak: Abort 403 Forbidden
   • ✓ Prevent wrong role access (admin/staff tidak bisa akses)

3. RESOURCE AUTHORIZATION (Inside Controller)
   if ($order->user_id !== auth()->id()) { 
       abort(403); 
   }
   • Validasi: Apakah order ini milik user yang login?
   • Jika tidak: Abort 403 Forbidden
   • ✓ Prevent user melihat order milik user lain

Implementasi:
   • Route middleware layer
   • Role checking layer
   • Resource ownership checking layer
   = 3-layer security untuk maksimal protection
```

---

## 🔟 Request-Response Cycle (Complete)

```
┌──────────────────────────────────────────────────────────────┐
│                  COMPLETE REQUEST-RESPONSE CYCLE             │
└──────────────────────────────────────────────────────────────┘

REQUEST MASUK:
  GET /customer/orders/5 HTTP/1.1
  Host: dio-app.local
  Cookie: XSRF-TOKEN=...; laravel_session=...
  
        ↓
        
ROUTING (routes/web.php):
  ✓ URL match dengan route pattern /customer/orders/{order}
  ✓ Implicit route binding: {order} → Order::findOrFail(5)
  
        ↓
        
MIDDLEWARE PIPELINE:
  1. Middleware: auth
     ✓ Check if user logged in via session/token
  2. Middleware: role:customer
     ✓ Check if user->role === 'customer'
  ✓ All middleware passed
  
        ↓
        
CONTROLLER EXECUTION:
  CustomerOrderController::detail($order)
  • $order = Order model instance with id=5
  • Check: $order->user_id === auth()->id()
  • Load relations: ['orderItems.product', 'payment']
  
        ↓
        
DATABASE QUERIES:
  Query 1: SELECT * FROM orders WHERE id = 5
  Query 2: SELECT * FROM order_items WHERE order_id = 5
  Query 3: SELECT * FROM products WHERE id IN (...)
  Query 4: SELECT * FROM payments WHERE order_id = 5
  
        ↓
        
RESPONSE GENERATION:
  • Compile Blade template: customer/orders/detail.blade.php
  • Inject variables: ['order' => $order]
  • Render HTML output
  
        ↓
        
HTTP RESPONSE:
  HTTP/1.1 200 OK
  Content-Type: text/html; charset=UTF-8
  Set-Cookie: laravel_session=...
  
  <!DOCTYPE html>
  <html>
  ...
  [HTML CONTENT]
  ...
  </html>
  
        ↓
        
BROWSER RENDERING:
  ✓ Parse HTML
  ✓ Load CSS (Tailwind)
  ✓ Load JS (Alpine.js)
  ✓ Render UI
  ✓ Display to user
```

---

## 🎯 Summary Execution Path

```
User Action: Click "Lihat Detail Pesanan"
     ↓
URL: /customer/orders/5
     ↓
Middleware: auth ✓ role:customer ✓
     ↓
Controller: CustomerOrderController->detail($order)
     ↓
Query DB: order, order_items, products, payment
     ↓
Compile: customer/orders/detail.blade.php
     ↓
Render: HTML Response
     ↓
Browser: Display halaman detail pesanan
```

---

## 🔗 Related Routes & Features

| Feature | URL | Method | Controller | Auth |
|---------|-----|--------|------------|------|
| List Pesanan | `/customer/orders` | GET | `CustomerOrderController@index` | ✓ |
| Detail Pesanan | `/customer/orders/{id}` | GET | `CustomerOrderController@detail` | ✓ |
| Batalkan Pesanan | `/customer/orders/{id}/cancel` | PUT | `CustomerOrderController@cancel` | ✓ |
| Form Pembayaran | `/order/{id}/payment` | GET | `CustomerOrderController@paymentForm` | ✓ |
| Upload Pembayaran | `/order/{id}/payment` | POST | `CustomerOrderController@storePayment` | ✓ |
| Dashboard | `/customer/dashboard` | GET | `CustomerDashboardController@index` | ✓ |

---

## 📚 Quick Reference

### Naming Convention
- **Routes**: kebab-case (`customer.orders.detail`)
- **Controllers**: PascalCase (`CustomerOrderController`)
- **Methods**: camelCase (`detail()`, `storePayment()`)
- **Models**: PascalCase (`Order`, `OrderItem`)
- **Blade Views**: snake_case (`customer/orders/detail.blade.php`)

### Key Files Location
```
app/
  Http/
    Controllers/
      Customer/
        CustomerOrderController.php  ← Main controller
  Models/
    Order.php                        ← Main model
    OrderItem.php                    ← Related model
    Payment.php                      ← Related model
    
routes/
  web.php                            ← Route definition
  
resources/
  views/
    customer/
      orders/
        detail.blade.php             ← Main view
```

---

**Last Updated**: 2026-06-12  
**System**: DIO APP (Catering Order Management System)  
**Framework**: Laravel 11 + Tailwind CSS + Alpine.js
