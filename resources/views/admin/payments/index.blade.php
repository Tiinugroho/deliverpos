@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
    <div class="space-y-6">
        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100">
            <div class="overflow-x-auto w-full flex-end">
                
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr
                            class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">No. Invoice Terkait</th>
                            <th class="py-3.5 px-4">Pelanggan</th>
                            <th class="py-3.5 px-4">Metode Bank</th>
                            <th class="py-3.5 px-4">Nominal Masuk</th>
                            <th class="py-3.5 px-4">Status Verifikasi</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-indigo-900">{{ $payment->order->order_number }}</td>
                                <td class="py-3.5 px-4 font-medium text-slate-900">{{ $payment->order->user->name }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $payment->payment_method }}</td>
                                <td class="py-3.5 px-4 font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4">
                                    @if($payment->status === 'unverified')
                                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Perlu Validasi</span>
                                    @elseif($payment->status === 'verified')
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Sah / Disetujui</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 rounded-md font-medium text-[10px]">Bukti Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-3 py-1.5 rounded transition inline-block text-[11px]">
                                        Buka Bukti Bayar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-slate-400">Tidak ada antrean pembayaran masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection