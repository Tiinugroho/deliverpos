@extends('layouts.app')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="max-w-xl mx-auto my-6">
    <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200 shadow-xs space-y-6">
        
        <div class="border-b border-slate-100 pb-4">
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">Keamanan Akun: Ganti Kata Sandi</h1>
            <p class="text-xs text-slate-500 mt-0.5">Silahkan perbarui kata sandi Anda secara berkala demi menjaga keamanan akun.</p>
        </div>

        <form action="{{ route('customer.password.update') }}" method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin mengubah kata sandi akun Anda sekarang? Anda harus login ulang setelah ini.');" 
              class="space-y-4 text-xs text-slate-700">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label for="current_password" class="font-semibold text-slate-700">Kata Sandi Saat Ini (Lama) <span class="text-rose-500">*</span></label>
                <input type="password" name="current_password" id="current_password" required
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-md focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 transition">
            </div>

            <div class="space-y-1.5">
                <label for="password" class="font-semibold text-slate-700">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-md focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 transition">
            </div>

            <div class="space-y-1.5">
                <label for="password_confirmation" class="font-semibold text-slate-700">Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi kata sandi baru"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-md focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 transition">
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 font-semibold">
                <a href="{{ route('customer.dashboard') }}" 
                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-md transition text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-indigo-900 hover:bg-indigo-950 text-white px-5 py-2.5 rounded-md transition shadow-xs cursor-pointer">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>

    </div>
</div>
@endsection