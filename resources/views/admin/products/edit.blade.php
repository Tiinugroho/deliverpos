@extends('layouts.admin')

@section('title', 'Perbarui Informasi Produk')

@section('content')
    <div class="w-full space-y-4">
        
        <div class="flex items-center gap-3 pt-2">
            <a href="{{ route('admin.products.index') }}"
                class="p-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition shadow-sm shrink-0"
                title="Kembali ke Daftar Produk">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Kembali</h1>
            </div>
        </div>

        <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-slate-100 w-full">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5 text-xs text-slate-700">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                        Nama Produk <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800">
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
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800">
                        @error('price')
                            <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                            Stok Toko <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800">
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
                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-800">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center p-3.5 bg-slate-50 rounded-2xl border border-slate-200/60 w-full">
                    <div class="shrink-0 mx-auto sm:mx-0">
                        @if ($product->image)
                            <img src="{{ asset('images/products/' . $product->image) }}"
                                class="w-20 h-20 object-cover rounded-xl border border-slate-300 shadow-sm" alt="Thumbnail Saat Ini">
                        @else
                            <div class="w-20 h-20 bg-slate-200 rounded-xl flex items-center justify-center text-slate-400 font-semibold text-[10px]">
                                No Photo
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 w-full space-y-1">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">
                            Ganti Gambar Sampul
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full bg-white border border-slate-200 rounded-xl px-3 py-1.5 file:mr-3 file:py-0.5 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-slate-500 cursor-pointer">
                        <p class="text-[9px] text-slate-400">Pilih berkas baru jika ingin memperbarui gambar utama di aplikasi.</p>
                        @error('image')
                            <p class="text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.products.index') }}"
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