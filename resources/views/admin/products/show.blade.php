@extends('layouts.admin')

@section('title', 'Detail Spesifikasi Produk')

@section('content')
    <div class="w-full space-y-4">
        
        <div class="flex items-center justify-between gap-4 pt-2 flex-wrap">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.index') }}"
                    class="p-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition shadow-sm shrink-0"
                    title="Kembali ke Daftar Produk">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Kembali</h1>
            </div>

            <a href="{{ route('admin.products.edit', $product->id) }}"
                class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 px-4 py-2 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Ubah Informasi
            </a>
        </div>

        <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-slate-100 w-full">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <div class="md:col-span-4 lg:col-span-3 flex flex-col items-center">
                    @if ($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="Foto {{ $product->product_name }}"
                            class="w-full aspect-square object-cover rounded-2xl shadow-sm border border-slate-200">
                    @else
                        <div class="w-full aspect-square bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-slate-400 gap-2">
                            <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 0 11-.75 0 .375 0 01.75 0z">
                                </path>
                            </svg>
                            <span class="text-[10px] font-bold uppercase tracking-wider">No Photo</span>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-8 lg:col-span-9 flex flex-col justify-between text-xs text-slate-700 space-y-5">
                    <div class="space-y-4">
                        <div>
                            <span class="bg-indigo-50 text-indigo-700 font-bold px-2.5 py-1 rounded-md text-[10px] tracking-wide border border-indigo-100 uppercase">
                                {{ $product->category->category_name ?? 'Kategori Umum' }}
                            </span>
                            <h2 class="text-2xl font-bold text-slate-900 mt-2 tracking-tight">
                                {{ $product->product_name }}
                            </h2>
                        </div>

                        <div class="h-px bg-slate-100"></div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Nilai Jual</span>
                                <span class="text-xl font-black text-[#2C5EAD]">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Status Persediaan</span>
                                @if ($product->stock <= 10)
                                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 border border-rose-100 rounded-md inline-block">
                                        {{ $product->stock }} Porsi Tersisa (Kritis)
                                    </span>
                                @else
                                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 border border-emerald-100 rounded-md inline-block">
                                        {{ $product->stock }} Porsi Siap Jual
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="h-px bg-slate-100"></div>

                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1.5">Rincian Deskripsi Komposisi</span>
                            <div class="p-3.5 bg-slate-50/70 rounded-2xl border border-slate-200/60 text-slate-600 leading-relaxed font-medium">
                                {{ $product->description ?? 'Pemilik toko belum menambahkan rincian deskripsi deskriptif untuk produk makanan/minuman ini.' }}
                            </div>
                        </div>
                    </div>

                    <div class="text-[10px] text-slate-400 font-medium pt-3 border-t border-slate-100 flex justify-between items-center flex-wrap gap-2">
                        <span>Ditambahkan pada: <span class="text-slate-500 font-semibold">{{ $product->created_at ? $product->created_at->format('d M Y H:i') : '-' }}</span></span>
                        <span>Pembaruan terakhir: <span class="text-slate-500 font-semibold">{{ $product->updated_at ? $product->updated_at->format('d M Y H:i') : '-' }}</span></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection