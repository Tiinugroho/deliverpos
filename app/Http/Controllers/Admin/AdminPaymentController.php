<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    public function index()
    {
        // Menampilkan antrean bukti pembayaran masuk
        $payments = Payment::with('order.user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('order.user', 'order.orderItems.product');
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        DB::beginTransaction();
        try {
            // Update status pembayaran ('verified' / 'rejected')
            $payment->update([
                'status' => $request->status
            ]);

            // OTOMATISASI LOGIKA: Jika pembayaran sah (verified), ubah status order menjadi confirmed
            if ($request->status === 'verified') {
                $payment->order->update([
                    'status' => 'confirmed'
                ]);
            }

            DB::commit();
            return redirect()->route('admin.payments.index')->with('success', 'Status verifikasi pembayaran berhasil disimpan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses verifikasi: ' . $e->getMessage());
        }
    }
}