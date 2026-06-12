<header
    class="sticky top-0 h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 lg:px-8 flex items-center justify-between z-35">
    <div class="flex items-center gap-4 flex-1 max-w-xl">
        <button @click="mobileSidebarOpen = true"
            class="lg:hidden p-2 text-slate-500 hover:text-slate-900 focus:outline-none cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="relative w-full hidden sm:block">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Cari menu makanan, nomor pesanan..."
                class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-100/70 rounded-xl text-xs focus:outline-none focus:border-[#2C5EAD] focus:bg-white transition-all">
        </div>
    </div>

    <div class="flex items-center gap-3">

        <div class="relative" @click.away="notificationDropdown = false">
            <button @click="notificationDropdown = !notificationDropdown; profileDropdown = false"
                class="h-10 w-10 rounded-xl bg-slate-50 border border-slate-100/70 text-slate-400 hover:text-slate-600 flex items-center justify-center relative focus:outline-none cursor-pointer group transition-colors">
                <svg class="w-4.5 h-4.5 text-slate-500 group-hover:text-slate-800 transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <span class="absolute top-2.5 right-2.5 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
            </button>

            <div x-show="notificationDropdown" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50 text-xs text-slate-600 space-y-1"
                style="display: none;">

                <div class="px-3 py-2 border-b border-slate-50 flex items-center justify-between mb-1">
                    <p class="font-bold text-slate-900 font-heading">Notifikasi Terbaru</p>
                    <span
                        class="text-[10px] bg-blue-50 text-[#2C5EAD] px-2 py-0.5 rounded-full font-semibold">Sistem</span>
                </div>

                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'cashier')
                    <div
                        class="flex items-start gap-4 p-3 hover:bg-slate-50 rounded-xl transition-all border-l-2 border-amber-500 bg-amber-50/20">
                        <div class="min-w-0 flex-1">
                            <p class="text-slate-700 leading-normal"><span
                                    class="font-semibold text-slate-900">Pembayaran Baru</span> masuk memerlukan
                                verifikasi berkas bukti transfer Anda.</p>
                        </div>
                    </div>
                @else
                    <div
                        class="flex items-start gap-4 p-3 hover:bg-slate-50 rounded-xl transition-all border-l-2 border-emerald-500 bg-emerald-50/20">
                        <div class="min-w-0 flex-1">
                            <p class="text-slate-700 leading-normal"><span class="font-semibold text-slate-900">Pesanan
                                    Diproses</span>. Status transaksi kuliner Anda saat ini berubah menjadi
                                dikonfirmasi.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="relative" @click.away="profileDropdown = false">
            <button @click="profileDropdown = !profileDropdown; notificationDropdown = false"
                class="flex items-center gap-2.5 border-l border-slate-100 pl-3 focus:outline-none cursor-pointer group">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80"
                    alt="Avatar"
                    class="h-9 w-9 rounded-xl object-cover ring-2 ring-[#C4E2F5] group-hover:ring-[#1591DC] transition-all">
                <div class="hidden xl:block text-left">
                    <p class="text-xs font-semibold text-slate-900 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 mt-1 font-medium flex items-center gap-0.5">
                        {{ auth()->user()->email }}</p>
                </div>
            </button>

            <div x-show="profileDropdown" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 p-1.5 z-50 text-xs text-slate-600 space-y-0.5"
                style="display: none;">

                <div class="px-3 py-2 border-b border-slate-50 mb-1">
                    <p class="font-semibold text-slate-950">Hak Akses Sistem</p>
                    <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider mt-0.5">
                        {{ auth()->user()->role }}</p>
                </div>

                <form action="{{ route('logout') }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem?');">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center gap-4 px-4 py-3 rounded-xl text-rose-600 hover:bg-rose-50/50 transition-all cursor-pointer">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span class="text-sm font-semibold tracking-wide">Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
