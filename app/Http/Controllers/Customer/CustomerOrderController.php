<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('order_date', 'desc')->get();
        return view('customer.orders.index', compact('orders'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $totalPrice = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    return redirect()->back()->with('error', "Stok untuk menu {$product->product_name} tidak mencukupi.");
                }
                $totalPrice += $product->price * $item['quantity'];
            }

            $orderNumber = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'order_date' => now(),
                'shipping_address' => $request->shipping_address,
                'note' => $request->notes, 
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $product->price
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            
            // Setelah checkout sukses, arahkan ke halaman form pembayaran (payment)
            return redirect()->route('payment.form', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // Method untuk melihat detail nota order
    public function detail(Order $order)
    {
        if ($order->user_id !== auth()->id()) { abort(403); }

        $order->load(['orderItems.product', 'payment']);
        
        $order->order_code = $order->order_number;
        if ($order->payment) {
            $order->payment->proof_image = $order->payment->proof_of_payment;
        }

        return view('customer.orders.detail', compact('order'));
    }

    // Method untuk form upload pembayaran (payment)
    public function paymentForm(Order $order)
    {
        if ($order->user_id !== auth()->id()) { abort(403); }
        
        $order->order_code = $order->order_number;
        return view('customer.orders.payment', compact('order'));
    }

    // METHOD BARU: Membatalkan Pesanan Pending & Mengembalikan Stok Produk
    public function cancel(Order $order)
    {
        // Pastikan order ini benar milik user yang sedang login
        if ($order->user_id !== auth()->id()) { abort(403); }

        // Batalkan hanya jika statusnya masih pending
        if ($order->status === 'pending') {
            DB::beginTransaction();
            try {
                // 1. Kembalikan stok untuk setiap item produk yang dibeli
                foreach ($order->orderItems as $item) {
                    $item->product->increment('stock', $item->quantity);
                }

                // 2. Ubah status pesanan menjadi cancelled
                $order->update([
                    'status' => 'cancelled'
                ]);

                DB::commit();
                return redirect()->route('customer.orders')->with('success', 'Pesanan Anda berhasil dibatalkan dan stok dikembalikan.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sedang diproses toko.');
    }

    public function storePayment(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) { abort(403); }

        $request->validate([
            'payment_method' => 'required|string',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $filename = 'PAY--' . time() . '.' . $request->proof_of_payment->extension();
        $request->proof_of_payment->move(public_path('storage/payments'), $filename);

        $bayar = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'payment_method' => $request->payment_method,
            'proof_of_payment' => $filename,
            'status' => 'unverified'
        ]);


        // SELESAI UNGHAH: Diarahkan ke detail, dan bawa session 'clear_cart' untuk menghapus localStorage
        return redirect()->route('customer.orders.detail', $order->id)
            ->with('success', 'Bukti transfer berhasil diunggah.')
            ->with('clear_cart', true);
    }
}