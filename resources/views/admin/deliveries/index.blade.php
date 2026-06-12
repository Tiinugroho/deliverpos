@extends('layouts.admin')

@section('title', 'Manajemen Pengantaran')

@section('content')
    <div class="w-full space-y-4">
        <div class="pt-2">
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">🚚 Pengantaran Internal Staf</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola daftar pengiriman makanan katering kustomer yang siap dilepas atau sedang berada di perjalanan.</p>
        </div>

        @if($deliveries->isEmpty())
            <div class="glass-card bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm w-full">
                <p class="text-slate-400 text-xs font-medium">Tidak ada tugas pengantaran untuk kurir saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                @foreach($deliveries as $item)
                    <div class="glass-card bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between overflow-hidden transition hover:shadow-md">
                        
                        <div class="p-5 space-y-3.5 text-xs text-slate-700">
                            <div class="flex justify-between items-center flex-wrap gap-2">
                                <span class="font-mono font-bold text-indigo-900 text-[13px]">#{{ $item->order_number }}</span>
                                
                                @if($item->status === 'confirmed')
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider">Siap Lepas</span>
                                @else
                                    <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider animate-pulse">🚚 Di Perjalanan</span>
                                @endif
                            </div>

                            <div class="h-px bg-slate-100"></div>

                            <div class="space-y-2 text-slate-600 font-medium">
                                <p class="text-slate-500"><strong class="text-slate-900 font-bold">Penerima:</strong> {{ $item->user->name ?? 'Pelanggan' }}</p>
                                <p class="text-slate-500"><strong class="text-slate-900 font-bold">No. WA / HP:</strong> {{ $item->user->phone_number ?? '-' }}</p>
                                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200/60 mt-1 space-y-0.5">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Alamat Tujuan Antar:</span>
                                    <span class="text-slate-700 font-semibold leading-relaxed block">{{ $item->shipping_address }}</span>
                                </div>
                                @if($item->note)
                                    <p class="text-[11px] text-amber-700 bg-amber-50/50 border border-amber-100 px-2 py-1 rounded-lg">💬 <span class="font-bold">Memo:</span> {{ $item->note }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="bg-slate-50/60 p-4 border-t border-slate-100 flex flex-col gap-2.5">
                            
                            <a href="{{ route('admin.deliveries.show', $item->id) }}" 
                               class="w-full bg-white hover:bg-slate-100 text-slate-700 font-bold py-2 px-4 rounded-xl text-xs transition border border-slate-200 shadow-3xs flex items-center justify-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Rincian Menu & Nota
                            </a>

                            @if($item->status === 'confirmed')
                                <form action="{{ route('admin.deliveries.update', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Lepas staf kurir sekarang? Status di halaman akun pelanggan akan berubah menjadi Sedang Diantar.');" class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="on_delivery">
                                    <button type="submit" class="w-full bg-[#2C5EAD] hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
                                        🚀 Driver Berangkat
                                    </button>
                                </form>
                            @elseif($item->status === 'on_delivery')
                                <form action="{{ route('admin.deliveries.update', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Pastikan makanan katering sudah diserahterimakan dengan benar ke alamat kustomer.');" class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
                                        ✅ Paket Sudah Diterima
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection