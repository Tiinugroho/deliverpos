@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="space-y-10">

    <section class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="space-y-1">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Produk Toko</h1>
                <p class="text-xs text-slate-500">Pilih produk yang kamu inginkan dan masukkan ke keranjang belanja.</p>
            </div>
            
            <span class="text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-md uppercase tracking-wider">
                Total Tersedia: {{ $products->count() }} Item
            </span>
        </div>

        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
            </div>

            <div>
                <select name="category" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition cursor-pointer">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-grow bg-indigo-900 hover:bg-indigo-950 text-white text-xs font-semibold py-2 rounded-md transition shadow-xs cursor-pointer flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Cari
                </button>
                
                @if(request('search') || request('category'))
                    <a href="{{ route('products.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold p-2 rounded-md transition flex items-center justify-center" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15.19M20 20v-5h-5.581"/>
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </section>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col h-full group">
                
                <a href="{{ route('products.show', $product->id) }}" class="bg-slate-100 h-44 flex items-center justify-center relative overflow-hidden block">
                    @if($product->image)
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                    @endif
                    <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-indigo-950 font-bold px-2 py-0.5 rounded text-[10px] uppercase border border-slate-200/50 z-10">
                        {{ $product->category->category_name }}
                    </span>
                </a>

                <div class="p-4 flex flex-col flex-grow space-y-4">
                    <div class="space-y-1">
                        <a href="{{ route('products.show', $product->id) }}" class="block group-hover:text-indigo-600 transition">
                            <h3 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $product->product_name }}</h3>
                        </a>
                        <p class="text-xs text-slate-400 line-clamp-2 font-light">{{ $product->description }}</p>
                    </div>
                    
                    <div class="pt-2 flex items-center justify-between border-t border-slate-100 mt-auto">
                        <div>
                            <p class="text-[9px] text-slate-400 font-medium uppercase tracking-wider">Harga</p>
                            <p class="text-sm font-bold text-indigo-950">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-[10px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>

                    @auth
                        @if(Auth::user()->role === 'customer')
                            <div class="pt-2 border-t border-slate-150 flex items-center gap-2">
                                <div class="w-16">
                                    <input type="number" id="qty-{{ $product->id }}" value="1" min="1" max="{{ $product->stock }}" class="w-full text-center p-1.5 border border-slate-200 rounded text-xs focus:outline-none focus:border-indigo-600 text-slate-700 bg-slate-50 font-medium">
                                </div>
                                
                                <button type="button" onclick="addToLocalStorageCart({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }}, {{ $product->stock }})" class="flex-grow bg-indigo-900 hover:bg-indigo-950 text-white font-semibold py-1.5 px-3 rounded text-xs transition flex items-center justify-center gap-1 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Beli
                                </button>
                            </div>
                        @else
                            <div class="text-[11px] text-center bg-amber-50 border border-amber-200 text-amber-800 p-2 rounded font-medium">
                                Hanya untuk Akun Pelanggan
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2 rounded text-xs transition block border border-slate-200">
                            Login Untuk Memesan
                        </a>
                    @endauth
                </div>

            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white border border-dashed border-slate-300 p-12 text-center rounded-xl text-xs text-slate-400 space-y-2 shadow-xs">
                <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="font-medium text-slate-600 text-sm">Produk Tidak Ditemukan</p>
                <div class="pt-2">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline font-medium">
                        Kembali ke Katalog Utama
                    </a>
                </div>
            </div>
        @endforelse
    </section>

</div>

<script>
function addToLocalStorageCart(id, name, price, maxStock) {
    let quantity = parseInt(document.getElementById('qty-' + id).value) || 1;
    
    // VALIDASI 1: Cek batas stok maksimum
    if (quantity > maxStock) {
        if(typeof window.askConfirmation !== 'undefined') {
            window.askConfirmation('Jumlah input melebihi batas sisa stok yang tersedia toko saat ini.', function() {});
        }
        return;
    }

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let foundIndex = cart.findIndex(item => item.id === id);

    if (foundIndex > -1) {
        // Cek jika akumulasi kuantitas melebihi stok makanan katering
        if ((cart[foundIndex].quantity + quantity) > maxStock) {
            toastr.error('Gagal! Total barang di keranjang melampaui batas stok produk.');
            return;
        }
        cart[foundIndex].quantity += quantity;
    } else {
        cart.push({ id: id, name: name, price: price, quantity: quantity });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    
    // PERBAIKAN: Menggunakan Toastr & Update Badge Instan tanpa Refresh Gila-gilaan
    if(typeof toastr !== 'undefined') {
        toastr.success(name + ' sukses dimasukkan ke keranjang belanja!');
        
        // Memperbarui badge keranjang navbar secara langsung
        let badge = document.getElementById('nav-cart-badge');
        if (badge) {
            let totalItem = cart.reduce((total, item) => total + item.quantity, 0);
            badge.innerText = totalItem;
        }
    } else {
        window.location.reload();
    }
}
</script>
@endsection