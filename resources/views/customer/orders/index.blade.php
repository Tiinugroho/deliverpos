@extends('layouts.app')

@section('title', 'Riwayat Pesanan Kamu')

@section('content')
<div class="space-y-8">
    <div class="border-b border-slate-200 pb-4 flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Riwayat Pesanan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Semua daftar transaksi dan status pesanan belanjaan kamu.</p>
        </div>
        <a href="{{ route('products.index') }}" class="bg-indigo-900 hover:bg-indigo-950 text-white text-xs font-semibold px-4 py-2 rounded-md transition shadow-xs flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Belanja Lagi
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 text-xs">
                        <th class="px-6 py-3">No. Pesanan</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Alamat Tujuan</th>
                        <th class="px-6 py-3">Total Belanja</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition text-xs text-slate-700">
                            <td class="px-6 py-4 font-mono font-bold text-indigo-900">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 truncate max-w-xs">
                                {{ $order->shipping_address }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($order->status === 'pending')
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Belum Bayar</span>
                                @elseif($order->status === 'confirmed')
                                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Dikonfirmasi</span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1 mx-auto">
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
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('customer.orders.detail', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold underline" title="Lihat Detail Pesanan">
                                        Detail
                                    </a>
                                    
                                    @if($order->status === 'pending')
                                        <a href="{{ route('payment.form', $order->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-2.5 py-1 rounded text-[10px] transition shadow-2xs">
                                            Bayar
                                        </a>

                                        <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Seluruh stok menu makanan akan dikembalikan otomatis.');" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1 rounded text-[10px] font-bold transition cursor-pointer">
                                                Batal
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Kamu belum pernah membuat pesanan di toko kami.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection