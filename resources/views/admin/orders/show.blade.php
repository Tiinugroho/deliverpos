@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-sm flex items-center gap-2 animate-fade-in">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between gap-6 items-start md:items-center">
            <div class="flex items-start gap-3">
                <a href="{{ route('admin.orders.index') }}" class="mt-1 p-2 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                </a>
                
                <div class="space-y-1">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Detail Invoice #{{ $order->order_number }}</h1>
                    <p class="text-xs text-slate-400">
                        Nama Pelanggan: <span class="font-semibold text-slate-700">{{ $order->user->name }}</span> |
                        Tanggal: <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y h:i A') }}</span>
                    </p>
                    <p class="text-xs text-slate-400">
                        Alamat: <span class="font-medium text-slate-600">{{ $order->shipping_address }}</span>
                        @if ($order->note)
                            | <span class="italic text-amber-600 font-light">Catatan: {{ $order->note }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="w-full md:w-auto self-stretch md:self-auto flex items-center justify-end">
                @if ($order->status === 'pending')
                    {{-- Kondisi 1: Pesanan baru masuk / bukti bayar belum diperiksa --}}
                    <div class="w-full md:w-auto bg-amber-50 text-amber-700 border border-amber-200 px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Validasi Pembayaran Pelanggan
                    </div>

                @elseif ($order->status === 'confirmed')
                    {{-- Kondisi 2: Pembayaran sudah sah, makanan siap diproses & dikirim --}}
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="on_delivery">
                        <button type="submit"
                            class="w-full md:w-auto bg-[#2C5EAD] hover:bg-blue-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm cursor-pointer flex items-center justify-center gap-2 h-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.088-2.42c-.04-.593-.563-1.04-1.157-1.04h-2.007M12 18.75v-11.25A2.25 2.25 0 009.75 5.25h-4.5A2.25 2.25 0 003 7.5v6.75m16.5 0a2.25 2.25 0 00-2.25-2.25H6.75m12.75 2.25l-1.058-2.115A2.25 2.25 0 0016.384 10.5H12">
                                </path>
                            </svg>
                            Mulai Antar Pesanan
                        </button>
                    </form>

                @elseif ($order->status === 'on_delivery')
                    {{-- Kondisi 3: Pesanan sedang di jalan, tampilkan tombol Selesai --}}
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="w-full md:w-auto"
                        onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan pesanan ini? Pastikan kurir telah mengonfirmasi bahwa makanan sudah sampai.');">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit"
                            class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm cursor-pointer flex items-center justify-center gap-2 h-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Selesaikan Pesanan (Sudah Tiba)
                        </button>
                    </form>

                @elseif ($order->status === 'completed')
                    {{-- Kondisi 4: Alur selesai mengunci status --}}
                    <div class="w-full md:w-auto bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-2 rounded-xl font-bold text-[12px] flex items-center justify-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Status Akhir: <span class="uppercase tracking-wider font-black">{{ $order->status }}</span>
                    </div>
                @else
                    {{-- Kondisi 5: Jika status ditolak/cancelled --}}
                    <div class="w-full md:w-auto bg-rose-50 text-rose-700 border border-rose-200 px-4 py-2.5 rounded-xl font-bold text-center text-[12px] shadow-sm">
                        Pesanan Dibatalkan
                    </div>
                @endif
            </div>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100">
            <div class="overflow-x-auto w-full">
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Menu / Produk</th>
                            <th class="py-3.5 px-4 text-center">Harga Satuan</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Beli</th>
                            <th class="py-3.5 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @foreach ($order->orderItems as $item)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $item->product->product_name }}</td>
                                <td class="py-3.5 px-4 text-center text-slate-500">
                                    Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-slate-800">{{ $item->quantity }}x</td>
                                <td class="py-3.5 px-4 text-right font-bold text-indigo-900">
                                    Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50/50 font-bold text-slate-900 border-t border-slate-200">
                            <td colspan="4" class="py-4 px-4 text-right uppercase text-[10px] text-slate-500 tracking-wider">
                                Total Pembayaran Keseluruhan:
                            </td>
                            <td class="py-4 px-4 text-right text-base text-indigo-950 font-black">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection