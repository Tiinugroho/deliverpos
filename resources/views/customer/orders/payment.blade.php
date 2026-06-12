@extends('layouts.app')

@section('title', 'Pembayaran Pesanan')

@section('content')
<div class="max-w-2xl mx-auto my-6">
    <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-xs space-y-6">
        
        <!-- Header Informasi -->
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="p-2.5 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Selesaikan Pembayaran</h1>
                <p class="text-xs text-slate-500">Pesanan kamu berhasil dibuat. Silahkan transfer sesuai nominal di bawah.</p>
            </div>
        </div>

        <!-- Detail Tagihan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-150 text-xs">
            <div class="space-y-1">
                <p class="text-slate-400 font-medium uppercase tracking-wider text-[10px]">Kode Pesanan</p>
                <p class="font-mono font-bold text-indigo-900 text-sm">{{ $order->order_code }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-slate-400 font-medium uppercase tracking-wider text-[10px]">Total yang Harus Dibayar</p>
                <p class="font-black text-slate-900 text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Panduan Rekening Bank Toko -->
        <div class="space-y-3">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Rekening Tujuan Transfer:</h2>
            <div class="border border-slate-200 rounded-lg divide-y divide-slate-150 overflow-hidden text-xs">
                <div class="p-3 flex justify-between items-center bg-white">
                    <div>
                        <p class="font-bold text-slate-800">BANK BCA</p>
                        <p class="text-slate-500 font-mono mt-0.5">123-4567-890</p>
                    </div>
                    <p class="text-slate-400 font-medium">a.n. Pemilik Toko</p>
                </div>
                <div class="p-3 flex justify-between items-center bg-white">
                    <div>
                        <p class="font-bold text-slate-800">BANK MANDIRI</p>
                        <p class="text-slate-500 font-mono mt-0.5">9876-5432-10123</p>
                    </div>
                    <p class="text-slate-400 font-medium">a.n. Pemilik Toko</p>
                </div>
            </div>
        </div>

        <!-- FORM UPLOAD BUKTI BAYAR -->
        <form action="{{ route('payment.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 pt-4 border-t border-slate-100">
            @csrf
            <input type="hidden" name="amount" value="{{ $order->total_price }}">

            <div class="space-y-1.5">
                <label for="payment_method" class="text-xs font-semibold text-slate-700">Metode Bank yang Kamu Gunakan</label>
                <select name="payment_method" id="payment_method" required class="w-full px-3 py-2 bg-slate-50 border @error('payment_method') border-rose-500 @else border-slate-200 @enderror rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition cursor-pointer">
                    <option value="">-- Pilih Bank Pengirim --</option>
                    <option value="Transfer BCA" {{ old('payment_method') == 'Transfer BCA' ? 'selected' : '' }}>Transfer BCA</option>
                    <option value="Transfer Mandiri" {{ old('payment_method') == 'Transfer Mandiri' ? 'selected' : '' }}>Transfer Mandiri</option>
                    <option value="Transfer BRI/BNI" {{ old('payment_method') == 'Transfer BRI/BNI' ? 'selected' : '' }}>Transfer BRI / BNI</option>
                    <option value="Lainnya" {{ old('payment_method') == 'Lainnya' ? 'selected' : '' }}>Rekening Bank Lainnya</option>
                </select>
                @error('payment_method') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5">
                <label for="proof_of_payment" class="text-xs font-semibold text-slate-700">Upload Foto / Gambar Bukti Transfer</label>
                <div class="w-full">
                    <input type="file" name="proof_of_payment" id="proof_of_payment" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-md bg-slate-50 focus:outline-none focus:bg-white transition cursor-pointer">
                </div>
                <p class="text-[10px] text-slate-400">Format yang diterima: JPG, JPEG, PNG. Maksimal ukuran file 2MB.</p>
                @error('proof_of_payment') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-900 hover:bg-indigo-950 text-white font-semibold py-2.5 px-4 rounded-md text-xs transition flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Kirim Bukti Pembayaran
            </button>
        </form>

    </div>
</div>
@endsection