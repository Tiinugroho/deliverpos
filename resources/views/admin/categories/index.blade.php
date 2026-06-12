@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="w-full space-y-4">
        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-sm flex items-center gap-2">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 shadow-sm flex items-center gap-2">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center flex-wrap gap-4 pt-2">
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Kategori Menu</h1>
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Tambah Kategori
            </a>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 w-full">
            <div class="overflow-x-auto w-full">
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Kategori</th>
                            <th class="py-3.5 px-4">Slug URL</th>
                            <th class="py-3.5 px-4">Deskripsi</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ $category->category_name }}</td>
                                <td class="py-3.5 px-4 font-mono text-indigo-700 text-[11px]">{{ $category->slug }}</td>
                                <td class="py-3.5 px-4 text-slate-500 truncate max-w-xs">{{ $category->description ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.categories.show', $category->id) }}"
                                           class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px]">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                           class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px]">
                                            Ubah
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px] cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada data kategori menu makanan/minuman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection