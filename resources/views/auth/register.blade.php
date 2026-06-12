@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="max-w-xl mx-auto my-6">
    <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-xs space-y-6">
        
        <div class="text-center space-y-2">
            <div class="inline-flex p-3 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-900 mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Akun Pelanggan</h1>
            <p class="text-xs text-slate-500">Isi form di bawah ini dengan lengkap untuk mulai buat pesanan.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-semibold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Nama lengkap kamu" class="w-full px-3 py-2 bg-slate-50 border @error('name') border-rose-500 @else border-slate-200 @enderror rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                    @error('name') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="phone_number" class="text-xs font-semibold text-slate-700">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required placeholder="Contoh: 081234567890" class="w-full px-3 py-2 bg-slate-50 border @error('phone_number') border-rose-500 @else border-slate-200 @enderror rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                    @error('phone_number') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Contoh: budi@gmail.com" class="w-full px-3 py-2 bg-slate-50 border @error('email') border-rose-500 @else border-slate-200 @enderror rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                @error('email') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5">
                <label for="address" class="text-xs font-semibold text-slate-700">Alamat Lengkap Pengiriman</label>
                <textarea name="address" id="address" rows="2" required placeholder="Tuliskan alamat lengkap pengantaran barang (nama jalan, nomor rumah, atau patokan)" class="w-full px-3 py-2 bg-slate-50 border @error('address') border-rose-500 @else border-slate-200 @enderror rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition resize-none">{{ old('address') }}</textarea>
                @error('address') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-semibold text-slate-700">Password (Minimal 8 Karakter)</label>
                    <input type="password" name="password" id="password" required placeholder="Buat password baru" class="w-full px-3 py-2 bg-slate-50 border @error('password') border-rose-500 @else border-slate-200 @enderror rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                    @error('password') <p class="text-[10px] text-rose-600 font-medium mt-0.5">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-semibold text-slate-700">Ulangi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ketik ulang password" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-900 hover:bg-indigo-950 text-white text-xs font-semibold py-2.5 rounded-md transition shadow-xs cursor-pointer flex items-center justify-center gap-1.5 pt-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Daftar Sekarang
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">Login di sini</a>
            </p>
        </div>

    </div>
</div>
@endsection