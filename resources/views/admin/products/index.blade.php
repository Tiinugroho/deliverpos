@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center flex-wrap gap-4">
            <h1 class="text-xl font-bold text-slate-800">Daftar Produk Toko</h1>
            <a href="{{ route('admin.products.create') }}"
                class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Tambah Produk Baru
            </a>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100">
            <div class="overflow-x-auto w-full">
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr
                            class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4 w-20 text-center">Gambar</th>
                            <th class="py-3.5 px-4">Nama Produk</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Harga Satuan</th>
                            <th class="py-3.5 px-4">Stok Toko</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                <td class="py-2 px-2 text-center">
                                    @if ($product->image)
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                            alt="Gambar {{ $product->product_name }}"
                                            class="w-12 h-12 object-cover rounded-xl shadow-sm border border-slate-200 mx-auto">
                                    @else
                                        <div
                                            class="w-12 h-12 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center mx-auto text-slate-400 font-medium text-[9px]">
                                            No Img</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $product->product_name }}</td>
                                <td class="py-3.5 px-4">
                                    <span
                                        class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md font-medium text-[10px] border border-slate-200">
                                        {{ $product->category->category_name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4">
                                    @if ($product->stock <= 10)
                                        <span
                                            class="text-rose-600 font-bold bg-rose-50 px-2 py-0.5 rounded border border-rose-100">{{ $product->stock }}
                                            Porsi (Kritis)</span>
                                    @else
                                        <span class="text-slate-600 font-medium">{{ $product->stock }} Tersedia</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px]">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px]">
                                            Ubah
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px]">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Belum ada data
                                    katalog produk. Silakan tambah baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
