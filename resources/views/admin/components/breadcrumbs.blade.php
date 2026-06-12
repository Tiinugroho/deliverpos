<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full shrink-0">
    <div>
        <h1 class="text-xl lg:text-2xl font-bold font-heading text-slate-900 tracking-tight">
            @yield('title', 'Dashboard')
        </h1>
        <p class="text-xs text-slate-400 mt-0.5">
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'cashier')
                Sistem monitoring log transaksi, kelola menu inventaris, dan verifikasi dana masuk pelanggan.
            @else
                Kelola pesanan kuliner Anda, lakukan unggah konfirmasi pembayaran, dan pantau pengantaran kurir.
            @endif
        </p>
    </div>

    <nav class="flex items-center gap-2 text-xs font-medium text-slate-400 bg-white/60 border border-slate-100 px-3 py-1.5 rounded-xl shadow-2xs self-start sm:self-center">
        <a href="{{ auth()->user()->role === 'customer' ? route('customer.dashboard') : route('admin.dashboard') }}"
            class="hover:text-[#2C5EAD] transition-colors flex items-center gap-1 text-slate-400 no-underline">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Home</span>
        </a>
        <svg class="w-2.5 h-2.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-slate-600 font-semibold">@yield('title', 'Dashboard')</span>
    </nav>
</div>