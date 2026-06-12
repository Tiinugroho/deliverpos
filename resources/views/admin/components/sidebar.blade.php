<aside
    class="fixed top-0 left-0 h-screen bg-white border-r border-slate-100 z-40 transition-all duration-300 hidden lg:flex flex-col justify-between w-[280px]"
    :class="sidebarOpen ? 'w-[280px]' : 'w-[88px]'" x-cloak>
    <div class="relative h-full flex flex-col justify-between w-full">
        <div>
            <div class="h-20 flex items-center px-6 border-b border-slate-50">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div
                        class="h-10 w-10 min-w-[40px] rounded-xl bg-white border border-slate-100 flex items-center justify-center shadow-sm overflow-hidden p-1.5">
                        <img src="{{ asset('assets/img/OIP.jpeg') }}" alt="Logo Platform"
                            class="w-full h-full object-contain">
                    </div>
                    <span class="font-heading font-bold text-base tracking-tight text-slate-900 whitespace-nowrap"
                        x-show="sidebarOpen">
                        {{ config('app.name', 'Corporate Order') }}
                    </span>
                </div>
            </div>

            <nav class="p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-140px)] w-full">
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'cashier')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z" />
                        </svg>
                        <span class="text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Dashboard
                            Admin</span>
                    </a>

                    <hr class="border-slate-100 my-3 mx-2">
                    <p class="text-[9px] uppercase font-bold text-slate-400 px-4 pb-1.5 tracking-wider"
                        x-show="sidebarOpen">Operasional Toko</p>

                    <a href="{{ route('admin.payments.index') }}"
                        class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.payments.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <div class="flex items-center gap-4 min-w-0">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap truncate" x-show="sidebarOpen">Cek
                                Pembayaran</span>
                        </div>
                        <span x-show="sidebarOpen"
                            class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 transition-colors {{ $unverifiedPaymentsCount > 0 ? 'bg-rose-600 text-white animate-pulse' : 'bg-emerald-600 text-white' }}">
                            {{ $unverifiedPaymentsCount }}
                        </span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <div class="flex items-center gap-4 min-w-0">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap truncate" x-show="sidebarOpen">Pesanan
                                Masuk</span>
                        </div>
                        <span x-show="sidebarOpen"
                            class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 transition-colors {{ $pendingOrdersCount > 0 ? 'bg-rose-600 text-white animate-pulse' : 'bg-emerald-600 text-white' }}">
                            {{ $pendingOrdersCount }}
                        </span>
                    </a>

                    <a href="{{ route('admin.deliveries.index') }}"
                        class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.deliveries.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <div class="flex items-center gap-4 min-w-0">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1M13 16h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 00.293-.707V12a1 1 0 00-1-1h-1V7a1 1 0 00-1-1h-2m-3 10a2 2 0 00-4 0m12 0a2 2 0 00-4 0" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap truncate"
                                x-show="sidebarOpen">Pengantaran Toko</span>
                        </div>
                        <span x-show="sidebarOpen"
                            class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 transition-colors {{ $activeDeliveriesCount > 0 ? 'bg-indigo-600 text-white animate-pulse' : 'bg-slate-100 text-slate-400' }}">
                            {{ $activeDeliveriesCount }}
                        </span>
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <hr class="border-slate-100 my-3 mx-2">
                        <p class="text-[9px] uppercase font-bold text-slate-400 px-4 pb-1.5 tracking-wider"
                            x-show="sidebarOpen">Katalog Usaha</p>

                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Kategori
                                Menu</span>
                        </a>

                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Daftar
                                Menu</span>
                        </a>

                        <hr class="border-slate-100 my-3 mx-2">
                        <p class="text-[9px] uppercase font-bold text-slate-400 px-4 pb-1.5 tracking-wider"
                            x-show="sidebarOpen">Sumber Daya</p>

                        <a href="{{ route('admin.staff.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Kelola
                                Karyawan</span>
                        </a>

                        <a href="{{ route('admin.customers.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.customers.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Data
                                Pelanggan</span>
                        </a>

                        <hr class="border-slate-100 my-3 mx-2">
                        <p class="text-[9px] uppercase font-bold text-slate-400 px-4 pb-1.5 tracking-wider"
                            x-show="sidebarOpen">Finansial</p>

                        <a href="{{ route('admin.reports.index') }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500 hover:bg-slate-50/80 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Laporan
                                Transaksi</span>
                        </a>
                    @endif
                @endif
            </nav>
        </div>

        <div class="p-4 border-t border-slate-50 bg-slate-50/40 w-full">
            <div class="flex items-center transition-all duration-300"
                :class="sidebarOpen ? 'gap-3 px-2 py-1' : 'justify-center'">
                <div class="relative shrink-0">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80"
                        alt="User Profile" class="h-10 w-10 rounded-xl object-cover ring-2 ring-[#C4E2F5]">
                    <span
                        class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-500 ring-2 ring-white animate-pulse"></span>
                </div>
                <div class="min-w-0 flex-1" x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-x-2">
                    <p class="text-xs font-semibold text-slate-900 truncate leading-none">{{ auth()->user()->name }}
                    </p>
                    <p class="text-[10px] text-indigo-600 font-bold mt-1 uppercase tracking-wider">
                        {{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>

        <button @click="sidebarOpen = !sidebarOpen"
            class="absolute top-7 -right-3.5 h-7 w-7 bg-white border border-slate-200 text-slate-500 hover:text-slate-900 rounded-full flex items-center justify-center shadow-sm hover:shadow transition-all cursor-pointer z-50"
            title="Toggle Sidebar Menu">
            <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="!sidebarOpen ? 'rotate-180' : ''"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
    </div>
</aside>


<div x-show="mobileSidebarOpen" class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm z-50 lg:hidden"
    @click="mobileSidebarOpen = false" x-transition style="display: none;"></div>


<aside
    class="fixed top-0 left-0 h-screen w-[270px] bg-white border-r border-slate-100 z-50 flex flex-col justify-between transition-transform duration-300 transform lg:hidden shadow-xl"
    :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>
    <div>
        <div class="h-20 flex items-center px-6 border-b border-slate-50 justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="h-10 w-10 min-w-[40px] rounded-xl bg-white border border-slate-100 flex items-center justify-center shadow-sm overflow-hidden p-1.5">
                    <img src="{{ asset('assets/img/OIP.jpeg') }}" alt="Logo"
                        class="w-full h-full object-contain">
                </div>
                <span class="font-heading font-bold text-base tracking-tight text-slate-900">
                    {{ config('app.name', 'Corporate Order') }}
                </span>
            </div>
            <button @click="mobileSidebarOpen = false" class="text-slate-400 hover:text-slate-900 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="p-4 space-y-1">
            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'cashier')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-4 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z" />
                    </svg>
                    <span class="text-sm font-medium">Dashboard Admin</span>
                </a>

                <hr class="border-slate-100 my-2">

                <a href="{{ route('admin.payments.index') }}"
                    class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.payments.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                    <div class="flex items-center gap-4">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-sm font-medium">Cek Pembayaran</span>
                    </div>
                    <span
                        class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $unverifiedPaymentsCount > 0 ? 'bg-rose-600 text-white' : 'bg-emerald-600 text-white' }}">{{ $unverifiedPaymentsCount }}</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                    <div class="flex items-center gap-4">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="text-sm font-medium">Pesanan Masuk</span>
                    </div>
                    <span
                        class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $pendingOrdersCount > 0 ? 'bg-rose-600 text-white' : 'bg-emerald-600 text-white' }}">{{ $pendingOrdersCount }}</span>
                </a>

                <a href="{{ route('admin.deliveries.index') }}"
                    class="flex items-center justify-between px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.deliveries.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                    <div class="flex items-center gap-4">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1M13 16h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 00.293-.707V12a1 1 0 00-1-1h-1V7a1 1 0 00-1-1h-2m-3 10a2 2 0 00-4 0m12 0a2 2 0 00-4 0" />
                        </svg>
                        <span class="text-sm font-medium">Pengantaran Toko</span>
                    </div>
                    <span
                        class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $activeDeliveriesCount > 0 ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                        {{ $activeDeliveriesCount }}
                    </span>
                </a>

                @if (auth()->user()->role === 'admin')
                    <hr class="border-slate-100 my-2">
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-4 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="text-sm font-medium">Kategori Menu</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-4 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-sm font-medium">Daftar Menu</span>
                    </a>

                    <hr class="border-slate-100 my-2">
                    <a href="{{ route('admin.staff.index') }}"
                        class="flex items-center gap-4 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.staff.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-sm font-medium">Kelola Karyawan</span>
                    </a>

                    <a href="{{ route('admin.customers.index') }}"
                        class="flex items-center gap-4 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.customers.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-sm font-medium">Data Pelanggan</span>
                    </a>

                    <hr class="border-slate-100 my-2">
                    <a href="{{ route('admin.reports.index') }}"
                        class="flex items-center gap-4 px-4 py-2.5 rounded-xl {{ request()->routeIs('admin.reports.*') ? 'bg-[#C4E2F5]/50 text-[#2C5EAD] font-semibold' : 'text-slate-500' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Laporan Transaksi</span>
                    </a>
                @endif
            @endif
        </nav>
    </div>
</aside>
