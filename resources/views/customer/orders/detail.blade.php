@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="space-y-6 text-xs md:text-sm">
    
    <div>
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-900 transition bg-white border border-slate-200 px-3 py-2 rounded-md shadow-2xs">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Riwayat Pesanan
        </a>
    </div>

    <div class="glass-card bg-white rounded-3xl p-6 shadow-2xs border border-slate-200">
        <div class="max-w-3xl mx-auto w-full flex items-center justify-between relative text-[11px] font-semibold">
            
            <div class="absolute left-0 top-[22px] w-full h-1 bg-slate-100 z-0 rounded-full"></div>
            <div class="absolute left-0 top-[22px] h-1 bg-[#2C5EAD] z-0 rounded-full transition-all duration-500"
                style="width: {{ $order->status == 'pending' ? '0%' : ($order->status == 'confirmed' ? '33.33%' : ($order->status == 'on_delivery' ? '66.66%' : '100%')) }};">
            </div>

            <div class="z-10 flex flex-col items-center text-center space-y-2 group">
                <div class="w-11 h-11 rounded-full flex items-center justify-center border transition-all duration-300 {{ in_array($order->status, ['pending', 'confirmed', 'on_delivery', 'completed']) ? 'bg-blue-50 text-[#2C5EAD] border-blue-200 ring-4 ring-blue-50/50' : 'bg-white text-slate-300 border-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="{{ in_array($order->status, ['pending', 'confirmed', 'on_delivery', 'completed']) ? 'text-slate-900 font-bold' : 'text-slate-400 font-medium' }}">Pesanan Dibuat</p>
            </div>

            <div class="z-10 flex flex-col items-center text-center space-y-2 group">
                <div class="w-11 h-11 rounded-full flex items-center justify-center border transition-all duration-300 {{ in_array($order->status, ['confirmed', 'on_delivery', 'completed']) ? 'bg-blue-50 text-[#2C5EAD] border-blue-200 ring-4 ring-blue-50/50' : 'bg-white text-slate-300 border-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <p class="{{ in_array($order->status, ['confirmed', 'on_delivery', 'completed']) ? 'text-slate-900 font-bold' : 'text-slate-400 font-medium' }}">Dikonfirmasi</p>
            </div>

            <div class="z-10 flex flex-col items-center text-center space-y-2 group">
                <div class="w-11 h-11 rounded-full flex items-center justify-center border transition-all duration-300 {{ in_array($order->status, ['on_delivery', 'completed']) ? 'bg-blue-50 text-[#2C5EAD] border-blue-200 ring-4 ring-blue-50/50' : 'bg-white text-slate-300 border-slate-200' }} {{ $order->status == 'on_delivery' ? 'animate-pulse' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1M13 16h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 00.293-.707V12a1 1 0 00-1-1h-1V7a1 1 0 00-1-1h-2m-3 10a2 2 0 00-4 0m12 0a2 2 0 00-4 0" />
                    </svg>
                </div>
                <p class="{{ in_array($order->status, ['on_delivery', 'completed']) ? 'text-slate-900 font-bold' : 'text-slate-400 font-medium' }}">Sedang Diantar</p>
            </div>

            <div class="z-10 flex flex-col items-center text-center space-y-2 group">
                <div class="w-11 h-11 rounded-full flex items-center justify-center border transition-all duration-300 {{ $order->status == 'completed' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-4 ring-emerald-50/50' : 'bg-white text-slate-300 border-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="{{ $order->status == 'completed' ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium' }}">Selesai</p>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs space-y-2">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Informasi Nota</p>
            <div class="space-y-1 text-xs">
                <p class="text-indigo-950 font-mono font-bold text-sm">#{{ $order->order_number }}</p>
                <p class="text-slate-500">Tanggal: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs space-y-2 md:col-span-2">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Alamat Pengantaran</p>
            <div class="space-y-1 text-xs">
                <p class="text-slate-700 font-medium">{{ $order->shipping_address }}</p>
                <p class="text-slate-400 font-light italic">Catatan: {{ $order->note ?? 'Tidak ada catatan tambahan.' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/70 flex justify-between items-center flex-wrap gap-2">
            <h2 class="text-xs font-bold text-indigo-950 uppercase tracking-wide">Rincian Barang Belanjaan</h2>
            
            <div>
                @if($order->status === 'pending')
                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Menunggu Pembayaran</span>
                @elseif($order->status === 'confirmed')
                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Pesanan Dikonfirmasi</span>
                @elseif($order->status === 'on_delivery')
                    <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Sedang Diantar Driver</span>
                @elseif($order->status === 'completed')
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Selesai / Diterima</span>
                @else
                    <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Pesanan Dibatalkan</span>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3 text-center">Harga Unit</th>
                        <th class="px-6 py-3 text-center">Jumlah Beli</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-slate-700">
                    @foreach($order->orderItems as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $item->product->product_name }}
                            </td>
                            <td class="px-6 py-4 text-center text-slate-500">
                                Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold">
                                {{ $item->quantity }}x
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-900">
                                Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    
                    <tr class="bg-slate-50/50 font-bold text-sm text-slate-900">
                        <td colspan="3" class="px-6 py-4 text-right uppercase text-[10px] text-slate-500 tracking-wider">Total Pembayaran:</td>
                        <td class="px-6 py-4 text-right text-indigo-950 font-black">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-2xs space-y-4">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wide border-b border-slate-100 pb-2">Status Bukti Transfer</h3>
        
        @if($order->payment)
            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-full sm:w-44 h-44 bg-slate-100 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center group relative shadow-inner">
                    <img src="{{ asset('storage/payments/' . $order->payment->proof_of_payment) }}" alt="Bukti Transfer" class="w-full h-full object-cover">
                    <a href="{{ asset('storage/payments/' . $order->payment->proof_of_payment) }}" target="_blank" class="absolute inset-0 bg-black/40 text-white font-semibold text-[10px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                        Buka Gambar Penuh
                    </a>
                </div>

                <div class="space-y-3 flex-grow text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-3 rounded-lg border border-slate-150">
                        <div>
                            <span class="text-slate-400 font-medium text-[10px] uppercase tracking-wider block">Metode Bank Pengirim</span>
                            <span class="font-semibold text-slate-800">{{ $order->payment->payment_method }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium text-[10px] uppercase tracking-wider block">Nominal Ditransfer</span>
                            <span class="font-bold text-indigo-900">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <span class="text-slate-500 font-medium">Hasil Verifikasi Kasir Toko:</span>
                        @if($order->payment->status === 'unverified')
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Menunggu Antrean Validasi</span>
                        @elseif($order->payment->status === 'verified')
                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Pembayaran Sah / Lolos</span>
                        @else
                            <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Bukti Ditolak / Salah</span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-slate-50 border border-dashed border-slate-200 p-6 text-center rounded-lg space-y-2">
                <p class="text-slate-500 font-medium text-xs">Kamu belum mengunggah berkas foto bukti transfer bank.</p>
                <div class="pt-1">
                    <a href="{{ route('payment.form', $order->id) }}" class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs px-4 py-2 rounded shadow-2xs transition cursor-pointer">
                        <svg class="w-4 h-4 mr-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16s-1 0-1-1V5s0-1 1-1h16s1 0 1 1v10s0 1-1 1H3zm12-4l-3-3m0 0l-3 3m3-3v8" />
                        </svg>
                        Unggah Bukti Transfer Sekarang
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@if(session('clear_cart'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            localStorage.removeItem('cart');
            let badge = document.getElementById('nav-cart-badge');
            if (badge) { 
                badge.innerText = '0'; 
            }
        });
    </script>
@endif
@endsection