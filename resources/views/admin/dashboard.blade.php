@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full flex-1 space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="glass-card bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pelanggan</span>
                    <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight font-heading">{{ number_format($totalCustomers) }}</h3>
                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full mt-1 inline-block">Aktif di Sistem</span>
                </div>
            </div>

            <div class="glass-card bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pesanan Hari Ini</span>
                    <div class="h-8 w-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight font-heading">{{ number_format($ordersToday) }}</h3>
                    <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full mt-1 inline-block">Transaksi Baru</span>
                </div>
            </div>

            <div class="glass-card bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                    <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight font-heading">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full mt-1 inline-block">Pesanan Selesai</span>
                </div>
            </div>

            <div class="glass-card bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Verifikasi Pending</span>
                    <div class="h-8 w-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight font-heading">{{ number_format($pendingVerification) }}</h3>
                    <span class="text-[10px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full mt-1 inline-block">Perlu Validasi</span>
                </div>
            </div>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-bold font-heading text-slate-900">Pesanan Masuk Terbaru</h3>
                    <p class="text-xs text-slate-400">Arus streaming data transaksi pesanan makanan & katering real-time</p>
                </div>

                <div class="flex items-center gap-2">
                    <button id="exportExcelBtn" class="bg-white hover:bg-slate-50 text-[#2C5EAD] px-3.5 py-1.5 rounded-xl text-[11px] font-semibold border border-slate-200 transition-all shadow-sm flex items-center gap-2 cursor-pointer h-9">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Excel</span>
                    </button>
                    <button id="exportPdfBtn" class="bg-white hover:bg-slate-50 text-[#2C5EAD] px-3.5 py-1.5 rounded-xl text-[11px] font-semibold border border-slate-200 transition-all shadow-sm flex items-center gap-2 cursor-pointer h-9">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span>PDF</span>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto w-full border border-slate-100 rounded-2xl bg-white">
            <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[10px] font-semibold bg-slate-50/50">
                            <th class="py-3.5 px-4">No.</th>
                            <th class="py-3.5 px-4">No. Pesanan</th>
                            <th class="py-3.5 px-4">Nama Pelanggan</th>
                            <th class="py-3.5 px-4">Alamat Pengiriman</th>
                            <th class="py-3.5 px-4">Total Biaya</th>
                            <th class="py-3.5 px-4">Status Pembayaran</th>
                            <th class="py-3.5 px-4">Status Alur</th>
                            <th class="py-3.5 px-4">Tanggal Masuk</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 divide-y divide-slate-50">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-[#C4E2F5]/10 transition-colors duration-150">
                                <td class="py-3.5 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-indigo-900">{{ $order->order_number }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $order->user->name }}</td>
                                <td class="py-3.5 px-4 text-slate-500 truncate max-w-[180px]">{{ $order->shipping_address }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                
                                <td class="py-3.5 px-4">
                                    @if($order->payment)
                                        @if($order->payment->status === 'verified')
                                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full text-[10px] font-semibold"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Lunas</span>
                                        @elseif($order->payment->status === 'unverified')
                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2.5 py-0.5 rounded-full text-[10px] font-semibold"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Dicek</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-0.5 rounded-full text-[10px] font-semibold"><span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>Ditolak</span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-600 px-2.5 py-0.5 rounded-full text-[10px] font-semibold"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Belum Bayar</span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4">
                                    @if($order->status === 'pending')
                                        <span class="bg-amber-50 text-amber-700 px-2 py-0.5 rounded-md text-[10px] font-semibold">Pending</span>
                                    @elseif($order->status === 'confirmed')
                                        <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md text-[10px] font-semibold">Dikonfirmasi</span>
                                    @elseif($order->status === 'on_delivery')
                                        <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-md text-[10px] font-semibold">Kurir Lapangan</span>
                                    @elseif($order->status === 'completed')
                                        <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-md text-[10px] font-semibold">Selesai</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 px-2 py-0.5 rounded-md text-[10px] font-semibold">Batal</span>
                                    @endif
                                </td>
                                
                                <td class="py-3.5 px-4 text-slate-400">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="h-7 w-7 mx-auto text-[#2C5EAD] hover:bg-blue-50 rounded-lg flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection