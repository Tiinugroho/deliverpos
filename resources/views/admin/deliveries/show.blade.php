@extends('layouts.admin')

@section('title', 'Detail Pengantaran #' . $order->order_number)

@section('content')
    <div class="w-full space-y-4">

        <div class="flex items-center gap-3 pt-2">
            <a href="{{ route('admin.deliveries.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-xl text-xs font-bold transition">
                ← Kembali
            </a>
            <div>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Detail Pengantaran #{{ $order->order_number }}
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">Periksa rincian item katering dan alamat tujuan sebelum kurir
                    berangkat.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-full items-start">

            <div class="lg:col-span-2 glass-card bg-white rounded-3xl border border-slate-100 shadow-sm p-5 space-y-4">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Daftar Menu Katering</h2>

                <div class="space-y-3">
                    @foreach ($order->orderDetails as $detail)
                        <div
                            class="flex items-center justify-between p-3 bg-slate-50/60 rounded-2xl border border-slate-100 text-xs text-slate-700 font-medium">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-lg shadow-2xs">
                                    🍱
                                </div>
                                <div>
                                    <p class="text-slate-950 font-bold">{{ $detail->product->name ?? 'Menu Terhapus' }}</p>
                                    <p class="text-slate-400 text-[11px]">Harga Satuan: Rp
                                        {{ number_format($detail->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-indigo-950 font-bold">x {{ $detail->quantity }} Porsi</p>
                                <p class="text-[11px] text-slate-500">Subtotal: Rp
                                    {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div
                    class="pt-2 flex justify-between items-center text-xs text-slate-900 font-bold border-t border-slate-100">
                    <span class="text-slate-500 font-medium">Total Muatan Nilai Nota:</span>
                    <span class="text-sm text-indigo-900 font-mono">Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="glass-card bg-white rounded-3xl border border-slate-100 shadow-sm p-5 space-y-4">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Tujuan</h2>

                <div class="text-xs space-y-2 text-slate-600">
                    <p><strong class="text-slate-900 font-bold block">Nama Penerima:</strong>
                        {{ $order->user->name ?? 'Pelanggan' }}</p>
                    <p><strong class="text-slate-900 font-bold block">No. WhatsApp/HP:</strong>
                        {{ $order->user->phone_number ?? '-' }}</p>

                    <div class="bg-indigo-50/40 border border-indigo-100/70 p-3 rounded-2xl space-y-1">
                        <span class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider block">Alamat
                            Pengantaran:</span>
                        <p class="text-indigo-950 font-semibold leading-relaxed">{{ $order->shipping_address }}</p>
                    </div>

                    @if ($order->note)
                        <div class="bg-amber-50/60 border border-amber-200/60 p-3 rounded-2xl text-amber-800">
                            <strong class="font-bold block text-[10px] uppercase tracking-wider">Catatan Tambahan
                                Pembeli:</strong>
                            <p class="font-medium mt-0.5">"{{ $order->note }}"</p>
                        </div>
                    @endif
                </div>

                <div class="h-px bg-slate-100 my-2"></div>

                <div class="space-y-2">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Status Saat
                        Ini:</span>
                    @if ($order->status === 'confirmed')
                        <div
                            class="w-full bg-amber-50 border border-amber-200 text-amber-800 text-center py-2 rounded-xl text-xs font-bold uppercase tracking-wide mb-3">
                            📦 Siap Dikemas & Lepas
                        </div>

                        <form action="{{ route('admin.deliveries.update', $order->id) }}" method="POST"
                            onsubmit="return confirm('Konfirmasi keberangkatan kurir internal?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="on_delivery">
                            <button type="submit"
                                class="w-full bg-[#2C5EAD] hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
                                🚀 Mulai Kirim Pesanan
                            </button>
                        </form>
                    @elseif($order->status === 'on_delivery')
                        <div
                            class="w-full bg-indigo-50 border border-indigo-200 text-indigo-800 text-center py-2 rounded-xl text-xs font-bold uppercase tracking-wide mb-3 animate-pulse">
                            🚚 Sedang Diantar Staf
                        </div>

                        <form action="{{ route('admin.deliveries.update', $order->id) }}" method="POST"
                            onsubmit="return confirm('Pastikan katering sudah diterima pemesan dengan benar.');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
                                ✅ Konfirmasi Selesai Diterima
                            </button>
                        </form>
                    @else
                        <div
                            class="w-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-center py-2 rounded-xl text-xs font-bold uppercase tracking-wide">
                            ✅ Transaksi Selesai
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
