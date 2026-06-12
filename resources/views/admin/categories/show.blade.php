@extends('layouts.admin')

@section('title', 'Rincian Kategori Menu')

@section('content')
    <div class="w-full space-y-4">
        
        <div class="flex items-center justify-between gap-4 pt-2 flex-wrap">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="p-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-slate-900 tracking-tight">Rincian Grup Kategori</h1>
            </div>

            <a href="{{ route('admin.categories.edit', $category->id) }}"
                class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 px-4 py-2 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                Ubah Informasi
            </a>
        </div>

        <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-slate-100 w-full space-y-4 text-xs text-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Nama Kategori</span>
                    <span class="text-lg font-bold text-slate-900">{{ $category->category_name }}</span>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Slug URL Kode</span>
                    <span class="font-mono bg-slate-50 text-indigo-700 px-2 py-1 rounded border border-slate-200 inline-block font-bold text-[11px]">{{ $category->slug }}</span>
                </div>
            </div>

            <div class="h-px bg-slate-100"></div>

            <div>
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Catatan Keterangan</span>
                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200/60 text-slate-600 font-medium leading-relaxed">
                    {{ $category->description ?? 'Tidak ada keterangan tambahan untuk kategori ini.' }}
                </div>
            </div>

            <div class="text-[10px] text-slate-400 font-medium pt-2 flex justify-between items-center border-t border-slate-100">
                <span>Dibuat: {{ $category->created_at ? $category->created_at->format('d M Y H:i') : '-' }}</span>
                <span>Diperbarui: {{ $category->updated_at ? $category->updated_at->format('d M Y H:i') : '-' }}</span>
            </div>
        </div>
    </div>
@endsection