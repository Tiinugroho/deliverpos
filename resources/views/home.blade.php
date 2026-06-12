@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="space-y-20 -mt-4">
    
    <section class="relative bg-gradient-to-br from-indigo-950 via-slate-900 to-indigo-900 text-white rounded-2xl overflow-hidden shadow-xl">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                <defs>
                    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative max-w-5xl mx-auto px-8 py-16 md:py-24 text-center space-y-8">
            <span class="inline-flex items-center gap-1.5 bg-indigo-500/20 border border-indigo-400/30 px-3 py-1 rounded-full text-xs font-semibold tracking-wide text-indigo-300 uppercase">
                Sistem Operasional Digital Terintegrasi
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight max-w-3xl mx-auto leading-tight">
                Efisiensi Distribusi Layanan Mandiri Pada {{ config('app.name', 'Sistem Kami') }}
            </h1>
            <p class="text-sm md:text-base text-slate-300 max-w-2xl mx-auto font-light leading-relaxed">
                Optimalkan pengelolaan transaksi komoditas usaha Anda dengan sistem pemantauan status pesanan real-time langsung dari kendali manajemen internal.
            </p>
            <div class="flex flex-wrap justify-center gap-4 pt-2">
                <a href="{{ route('products.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-3 rounded-md transition transform hover:-translate-y-0.5 shadow-md flex items-center gap-2 group">
                    Jelajahi Katalog
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                @guest
                    <a href="{{ route('register') }}" class="bg-slate-800/80 hover:bg-slate-800 text-slate-200 hover:text-white text-sm font-semibold px-6 py-3 rounded-md border border-slate-700 transition">
                        Kemitraan Baru
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 space-y-12">
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Infrastruktur Alur Utama</h2>
            <p class="text-xs text-slate-500 max-w-md mx-auto">Keunggulan manajemen operasional arsitektur {{ config('app.name', 'Sistem') }}.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition duration-300 space-y-4 group">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm tracking-tight">Pemesanan Multi-Kategori</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Sistem memfasilitasi akumulasi beberapa komoditas sekaligus dalam satu nomor invoice, lengkap dengan kalkulasi desimal harga yang akurat.
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition duration-300 space-y-4 group">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm tracking-tight">Validasi Pembayaran Sah</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Setiap unggahan lampiran bukti transfer dana pelanggan melewati sistem antrean verifikasi kasir internal guna mencegah manipulasi piutang.
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition duration-300 space-y-4 group">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm tracking-tight">Distribusi Lapangan Responsif</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Pengendalian status transit produk dikelola langsung oleh pemilik usaha melalui perangkat seluler saat bertindak sebagai kurir di lapangan.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 space-y-10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-5">
            <div class="space-y-1">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Komoditas Produk Terkini</h2>
                <p class="text-xs text-slate-500">Daftar item inventaris aktif pada platform {{ config('app.name', 'toko') }}.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 flex items-center gap-1 transition bg-indigo-50 px-3 py-2 rounded-md border border-indigo-100">
                Lihat Semua Katalog 
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col h-full group">
                    <div class="bg-slate-100 h-44 flex items-center justify-center relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                        @endif
                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-indigo-950 font-bold px-2 py-0.5 rounded text-[10px] uppercase border border-slate-200/50">
                            {{ $product->category->category_name }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-grow space-y-3">
                        <div class="space-y-1">
                            <h3 class="font-bold text-slate-900 text-sm line-clamp-1 group-hover:text-indigo-600 transition">{{ $product->product_name }}</h3>
                            <p class="text-xs text-slate-400 line-clamp-2 font-light">{{ $product->description }}</p>
                        </div>
                        
                        <div class="pt-2 flex items-center justify-between mt-auto border-t border-slate-100">
                            <div>
                                <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Harga Unit</p>
                                <p class="text-sm font-bold text-indigo-950">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="text-[11px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 bg-slate-50 border border-dashed border-slate-200 p-8 text-center rounded-xl text-xs text-slate-400">
                    <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                    </svg>
                    Data produk belum dimuat ke dalam basis data sistem.
                </div>
            @endforelse
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 bg-slate-100 border border-slate-200 rounded-2xl p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Komitmen Efisiensi Distribusi</h2>
            <p class="text-xs text-slate-500 leading-relaxed font-light">
                Melalui infrastruktur perangkat lunak pada {{ config('app.name', 'platform kami') }}, kami memastikan siklus data transaksi berjalan tanpa hambatan birokrasi pihak ketiga. Dari proses verifikasi kasir hingga pembaruan status lapangan oleh manajemen internal, akuntabilitas data dijamin valid.
            </p>
            <div class="space-y-2 pt-2 text-xs font-medium text-slate-700">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Akurasi Pencatatan Inventaris Komoditas Secara Otomatis.
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Keamanan Autentikasi Pengguna Menggunakan Proteksi Enkripsi.
                </div>
            </div>
        </div>
        
        <div class="flex justify-center">
            <svg class="w-full max-w-xs text-indigo-900/10" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="20" y="20" width="120" height="120" rx="16" fill="currentColor" stroke="currentColor" stroke-width="2"/>
                <rect x="60" y="60" width="120" height="120" rx="16" fill="indigo-600" fill-opacity="0.2" stroke="indigo-600" stroke-width="2"/>
                <circle cx="120" cy="120" r="30" fill="currentColor"/>
                <path d="M110 120L117 127L130 114" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </section>

</div>
{{-- Hapus skrip ini jika aplikasi sudah siap diproduksi (Production) --}}
<script>
    // Memaksa hapus keranjang jika database baru saja di-reset kosong
    @guest
        localStorage.removeItem('cart');
    @endguest
</script>
@endsection