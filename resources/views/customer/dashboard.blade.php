@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-8">
    <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-xs flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-xl font-bold text-indigo-950">Selamat Datang Kembali, {{ Auth::user()->name }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pantau status pesanan dan riwayat belanja Anda di sini.</p>
        </div>
        <a href="{{ route('products.index') }}" class="bg-indigo-900 text-white text-xs font-semibold px-4 py-2.5 rounded-md hover:bg-indigo-950 transition shadow-xs flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Buat Pesanan Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pembelian Sukses</p>
                <p class="text-xl font-bold text-slate-900 mt-1">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</p>
            </div>
            <div class="bg-emerald-50 text-emerald-600 p-3 rounded-md border border-emerald-150">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menunggu Pembayaran</p>
                <p class="text-xl font-bold text-slate-900 mt-1">{{ $pesananPending }} Pesanan</p>
            </div>
            <div class="bg-amber-50 text-amber-600 p-3 rounded-md border border-amber-150">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sedang Diproses / Diantar</p>
                <p class="text-xl font-bold text-slate-900 mt-1">{{ $pesananDiproses }} Transaksi</p>
            </div>
            <div class="bg-indigo-50 text-indigo-600 p-3 rounded-md border border-indigo-150">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/70">
            <h2 class="text-sm font-bold text-indigo-950 uppercase tracking-wide">5 Transaksi Terakhir Anda</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 text-xs">
                        <th class="px-6 py-3">Kode Order</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Alamat Pengiriman</th>
                        <th class="px-6 py-3">Total Harga</th>
                        <th class="px-6 py-3 text-center">Status Sistem</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-mono font-bold text-indigo-900 text-xs">
                                <a href="{{ route('customer.orders.detail', $order->id) }}" class="hover:underline">
                                    {{ $order->order_code }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">
                                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 truncate max-w-xs text-xs">
                                {{ $order->shipping_address }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800 text-xs">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($order->status === 'pending')
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Menunggu Bukti</span>
                                @elseif($order->status === 'confirmed')
                                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Dikonfirmasi</span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="bg-indigo-100 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                        <svg class="w-3 h-3 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                                        </svg>
                                        Sedang Diantar
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Selesai</span>
                                @else
                                    <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Batal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('customer.orders.detail', $order->id) }}" class="inline-flex items-center justify-center bg-indigo-900 hover:bg-indigo-950 text-white text-[11px] font-semibold px-3 py-1.5 rounded transition shadow-2xs">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-xs">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4M22 6H2m20 12H2"/>
                                </svg>
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection