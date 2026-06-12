@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="max-w-12xl mx-auto space-y-4">

        <div class="flex items-center gap-3 pt-2">
            <a href="{{ route('admin.products.index') }}"
                class="p-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition shadow-sm shrink-0"
                title="Kembali ke Daftar Produk">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
            </a>
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">Kembali</h1>
        </div>

        <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5 text-xs text-slate-700">
                @csrf

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                        Nama Produk <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" required
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800"
                        placeholder="Contoh: Nasi Kotak Ayam Bakar">
                    @error('product_name')
                        <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1 space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select name="category_id" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800 cursor-pointer">
                            <option value="">-- Pilih --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                            Harga (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800"
                            placeholder="25000">
                        @error('price')
                            <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                            Stok Awal <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800"
                            placeholder="100">
                        @error('stock')
                            <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                        Deskripsi Menu / Produk
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800"
                        placeholder="Deskripsikan lauk pauk, isi kotak atau racikan detail menu kuliner...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                        Gambar Sampul
                    </label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 text-slate-500 cursor-pointer">
                    <p class="text-[10px] text-slate-400">Rekomendasi rasio persegi 1:1, ukuran maksimal berkas sebesar 2
                        MB.</p>
                    @error('image')
                        <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-semibold transition cursor-pointer">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition shadow-sm cursor-pointer">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
