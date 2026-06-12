@extends('layouts.admin')

@section('title', 'Ubah Data Kategori')

@section('content')
    <div class="w-full space-y-4">
        
        <div class="flex items-center gap-3 pt-2">
            <a href="{{ route('admin.categories.index') }}"
                class="p-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Edit Informasi Kategori</h1>
            </div>
        </div>

        <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-slate-100 w-full">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5 text-xs text-slate-700">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}" required
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800">
                    @error('category_name')
                        <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                        Deskripsi Kategori
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-semibold transition cursor-pointer">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition shadow-sm cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection