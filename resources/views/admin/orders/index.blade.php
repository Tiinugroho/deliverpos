@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="space-y-6">
        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100">
            <div class="overflow-x-auto w-full flex-end">
                
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr
                            class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4">No</th>
                            <th class="py-3.5 px-4">No. Invoice</th>
                            <th class="py-3.5 px-4">Pelanggan</th>
                            <th class="py-3.5 px-4">Total Biaya</th>
                            <th class="py-3.5 px-4">Status Alur</th>
                            <th class="py-3.5 px-4">Tanggal Masuk</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-indigo-900">{{ $order->order_number }}</td>
                                <td class="py-3.5 px-4 font-medium text-slate-900">{{ $order->user->name }}</td>
                                <td class="py-3.5 px-4 font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($order->status === 'pending')
                                        <span
                                            class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Pending</span>
                                    @elseif($order->status === 'confirmed')
                                        <span
                                            class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Dikonfirmasi</span>
                                    @elseif($order->status === 'on_delivery')
                                        <span
                                            class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Sedang
                                            Diantar</span>
                                    @elseif($order->status === 'completed')
                                        <span
                                            class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Selesai</span>
                                    @else
                                        <span
                                            class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Batal</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y h:i A') }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-3 py-1.5 rounded transition inline-block text-[11px]">
                                        Detail / Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data pesanan di dalam
                                    sistem.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
