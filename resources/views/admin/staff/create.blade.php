@extends('layouts.admin')

@section('title', 'Tambah Karyawan Baru')

@section('content')
    <div class="w-full space-y-4">
        
        <div class="flex items-center gap-3 pt-2">
            <a href="{{ route('admin.staff.index') }}"
                class="p-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Pendaftaran Akun Karyawan</h1>
            </div>
        </div>

        <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-slate-100 w-full">
            <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-5 text-xs text-slate-700">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800" placeholder="Contoh: Siti Aminah">
                        @error('name') <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-400 uppercase tracking-wider text-[10px]">Otoritas / Hak Akses</label>
                        <input type="text" value="Kasir / Staff" disabled
                            class="w-full bg-slate-100 border border-slate-200 text-slate-400 font-bold rounded-xl px-3.5 py-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">Alamat Email Login <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800" placeholder="siti@gmail.com">
                        @error('email') <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">Kata Sandi / Password <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800" placeholder="Minimal 8 Karakter">
                        @error('password') <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1.5 md:col-span-1">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">Nomor Handphone</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800" placeholder="08XXXXXXXXXX">
                        @error('phone_number') <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">Alamat Domisili Rumah</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800" placeholder="Nama jalan, nomor rumah...">
                        @error('address') <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.staff.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-semibold transition cursor-pointer">Batal</a>
                    <button type="submit" class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition shadow-sm cursor-pointer">Simpan Data Karyawan</button>
                </div>
            </form>
        </div>
    </div>
@endsection