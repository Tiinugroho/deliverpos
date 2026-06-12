@extends('layouts.admin')

@section('title', 'Laporan Transaksi Finansial')

@section('content')
    <div class="w-full space-y-4">
        
        <div class="pt-2">
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">Laporan & Analisis Transaksi</h1>
            <p class="text-xs text-slate-400 mt-0.5">Pantau ringkasan akumulasi omset penjualan toko dari pesanan yang telah sukses dikirim.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="glass-card bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="h-12 w-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Pendapatan (Omset)</span>
                    <span class="text-xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="glass-card bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="h-12 w-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2C5EAD] shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Jumlah Pesanan Selesai</span>
                    <span class="text-xl font-black text-slate-900 tracking-tight">{{ $totalTransactions }} Nota Meluncur</span>
                </div>
            </div>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 shadow-sm border border-slate-100 w-full">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-3 text-xs text-slate-700">
                <div class="grid grid-cols-2 gap-3 flex-1 w-full">
                    <div class="space-y-1">
                        <label class="block font-bold text-slate-400 uppercase tracking-wider text-[9px]">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-500 transition text-slate-800 font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-bold text-slate-400 uppercase tracking-wider text-[9px]">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-500 transition text-slate-800 font-medium">
                    </div>
                </div>
                
                <div class="flex gap-2 w-full md:w-auto shrink-0">
                    <button type="submit" class="w-full md:w-auto bg-[#2C5EAD] hover:bg-blue-700 text-white font-bold h-9 px-4 rounded-xl transition shadow-sm cursor-pointer">
                        Filter Laporan
                    </button>
                    @if(request()->filled('start_date'))
                        <a href="{{ route('admin.reports.index') }}" class="w-full md:w-auto bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold h-9 px-4 rounded-xl transition flex items-center justify-center text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 w-full">
            <div class="overflow-x-auto w-full">
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">No. Invoice Terkait</th>
                            <th class="py-3.5 px-4">Nama Pelanggan</th>
                            <th class="py-3.5 px-4 text-center">Waktu Selesai</th>
                            <th class="py-3.5 px-4 text-right">Total Belanja Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @forelse($completedOrders as $order)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-indigo-900">#{{ $order->order_number }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $order->user->name }}</td>
                                <td class="py-3.5 px-4 text-center text-slate-500">
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-black text-slate-900">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Tidak ditemukan rekaman transaksi komersial pada periode waktu tersebut.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection