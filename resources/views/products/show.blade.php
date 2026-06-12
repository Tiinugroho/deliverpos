@extends('layouts.app')

@section('title', $product->product_name)

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-900 transition bg-white border border-slate-200 px-3 py-2 rounded-md shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Katalog
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
        
        <div class="bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center h-72 md:h-96 overflow-hidden relative">
            @if($product->image)
                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
            @else
                <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
            @endif
            <span class="absolute top-4 left-4 bg-indigo-900 text-white font-bold px-2.5 py-1 rounded text-[10px] uppercase tracking-wider shadow-sm">
                {{ $product->category->category_name }}
            </span>
        </div>

        <div class="flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="space-y-1">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight leading-tight">{{ $product->product_name }}</h1>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Kategori: {{ $product->category->category_name }}</p>
                </div>

                <div class="bg-slate-50 border border-slate-150 rounded-lg p-4">
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Harga per Unit</p>
                    <p class="text-2xl font-black text-indigo-950 mt-0.5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="space-y-1.5">
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Deskripsi / Keterangan:</h2>
                    <p class="text-xs text-slate-500 leading-relaxed font-light">
                        {{ $product->description ?? 'Tidak ada deskripsi tambahan untuk produk ini.' }}
                    </p>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 space-y-4">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500 font-medium">Status Ketersediaan:</span>
                    @if($product->stock > 0)
                        <span class="text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded font-bold uppercase tracking-wide text-[10px]">
                            Stok Tersedia ({{ $product->stock }} item)
                        </span>
                    @else
                        <span class="text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded font-bold uppercase tracking-wide text-[10px]">
                            Stok Habis
                        </span>
                    @endif
                </div>

                @auth
                    @if(Auth::user()->role === 'customer')
                        @if($product->stock > 0)
                            <div class="flex items-end gap-4">
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase block">Jumlah</label>
                                    <div class="flex items-center bg-slate-50 border border-slate-200 rounded-md p-1 h-9">
                                        <button type="button" id="btn-decrement" class="bg-white hover:bg-slate-200 text-slate-700 font-bold w-7 h-7 flex items-center justify-center rounded border border-slate-200 transition cursor-pointer select-none text-xs">-</button>
                                        
                                        <span id="display-qty" class="font-bold w-10 text-center text-xs text-slate-800">1</span>
                                        
                                        <button type="button" id="btn-increment" class="bg-white hover:bg-slate-200 text-slate-700 font-bold w-7 h-7 flex items-center justify-center rounded border border-slate-200 transition cursor-pointer select-none text-xs">+</button>
                                    </div>
                                </div>
                                
                                <div class="flex-grow">
                                    <button type="button" onclick="addProductFromDetail({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }}, {{ $product->stock }})" class="w-full h-9 bg-indigo-900 hover:bg-indigo-950 text-white font-semibold rounded-md text-xs transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Masukkan Keranjang Belanja
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-xs text-center bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-md font-medium">
                            Akun staf/admin tidak dapat melakukan simulasi pembelian produk.
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 rounded-md text-xs transition block border border-slate-200 shadow-xs">
                        Silahkan Login Terlebih Dahulu Untuk Memesan
                    </a>
                @endauth
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const maxStock = parseInt("{{ $product->stock }}") || 0;
    const btnDecrement = document.getElementById('btn-decrement');
    const btnIncrement = document.getElementById('btn-increment');
    const displayQty = document.getElementById('display-qty');

    if(displayQty) {
        btnDecrement.onclick = function() {
            let currentQty = parseInt(displayQty.innerText) || 1;
            if (currentQty > 1) {
                displayQty.innerText = currentQty - 1;
            }
        };

        btnIncrement.onclick = function() {
            let currentQty = parseInt(displayQty.innerText) || 1;
            if (currentQty < maxStock) {
                displayQty.innerText = currentQty + 1;
            } else {
                // PERBAIKAN: Alert melampaui stok diganti memanggil Modal Global Layout Anda
                if(typeof window.askConfirmation !== 'undefined') {
                    window.askConfirmation('Jumlah menu kuliner yang Anda minta sudah batas maksimum ketersediaan stok.', function() {});
                }
            }
        };
    }
});

function addProductFromDetail(id, name, price, maxStock) {
    let quantity = parseInt(document.getElementById('display-qty').innerText) || 1;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let foundIndex = cart.findIndex(item => item.id === id);

    if (foundIndex > -1) {
        if ((cart[foundIndex].quantity + quantity) > maxStock) {
            toastr.error('Gagal! Akumulasi kuantitas di keranjang melampaui sisa stok produk.');
            return;
        }
        cart[foundIndex].quantity += quantity;
    } else {
        cart.push({ id: id, name: name, price: price, quantity: quantity });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    
    // PERBAIKAN: Tampilkan Toastr lalu pindah halaman secara mulus sesudahnya
    if(typeof toastr !== 'undefined') {
        toastr.success('Sukses! Menambahkan ' + name + ' ke keranjang belanja.');
        
        // Jeda waktu 1 detik agar konsumen sempat melihat animasi Toastr Berhasil
        setTimeout(function() {
            window.location.href = "{{ route('cart.index') }}";
        }, 1000);
    } else {
        window.location.href = "{{ route('cart.index') }}";
    }
}
</script>
@endsection