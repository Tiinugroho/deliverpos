@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="space-y-6">
    <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between gap-6 items-start md:items-center">
        <div class="space-y-1">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Validasi Finansial #{{ $payment->order->order_number }}</h1>
            <p class="text-xs text-slate-400">
                Nama Pelanggan: <span class="font-semibold text-slate-700">{{ $payment->order->user->name }}</span> | 
                Metode Bank: <span class="font-semibold text-slate-700">{{ $payment->payment_method }}</span>
            </p>
            <p class="text-xs text-slate-400">
                Nominal Wajib Transfer: <span class="text-indigo-950 font-black text-sm">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </p>
        </div>

        <div class="shrink-0 w-full md:w-auto self-stretch md:self-auto flex items-center justify-end">
            @if($payment->status === 'unverified')
                <div class="flex gap-2 w-full md:w-auto">
                    <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="flex-1 md:flex-none">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="verified">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold h-9 px-4 rounded-xl text-xs transition shadow-sm cursor-pointer">
                            Approve (Sah)
                        </button>
                    </form>

                    <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="flex-1 md:flex-none">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold h-9 px-4 rounded-xl text-xs transition shadow-sm cursor-pointer">
                            Tolak Bukti
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-md font-medium text-[12px]">
                    Status Audit Akhir: <span class="text-indigo-950 font-black">{{ $payment->status }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="glass-card bg-white rounded-3xl p-5 shadow-sm border border-slate-100 space-y-3">
            <p class="font-bold text-slate-900 text-xs uppercase tracking-wide">Lampiran Dokumen Rekening</p>
            <div class="w-full bg-slate-50 rounded-2xl border border-slate-150 overflow-hidden flex items-center justify-center max-h-[380px] shadow-inner p-1">
                <img src="{{ asset('storage/payments/' . $payment->proof_of_payment) }}" alt="Bukti Transfer Pelanggan" class="w-full h-full object-contain rounded-xl">
            </div>
            <a href="{{ asset('storage/payments/' . $payment->proof_of_payment) }}" target="_blank" class="block text-center text-xs text-[#2C5EAD] hover:underline font-semibold">Buka Gambar Jendela Penuh</a>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 lg:col-span-2">
            <div class="overflow-x-auto w-full flex-end">

                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Menu / Produk</th>
                            <th class="py-3.5 px-4 text-center">Harga Jual</th>
                            <th class="py-3.5 px-4 text-center">Qty</th>
                            <th class="py-3.5 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @foreach($payment->order->orderItems as $item)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $item->product->product_name }}</td>
                                <td class="py-3.5 px-4 text-center text-slate-400">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-center font-bold text-slate-800">{{ $item->quantity }}x</td>
                                <td class="py-3.5 px-4 text-right font-bold text-indigo-900">
                                    Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50/50 font-bold text-slate-900 border-t border-slate-200">
                            <td colspan="4" class="py-4 px-4 text-right uppercase text-[10px] text-slate-500 tracking-wider">Total Akumulasi Pembayaran:</td>
                            <td class="py-4 px-4 text-right text-base text-indigo-950 font-black">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection