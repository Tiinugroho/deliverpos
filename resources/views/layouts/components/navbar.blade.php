<header class="bg-white border-b border-slate-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <div class="flex items-center gap-2">
                <div class="bg-indigo-900 text-white p-2 rounded-md shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-base sm:text-xl font-bold tracking-tight text-indigo-950 uppercase whitespace-nowrap">
                    {{ config('app.name', 'TOKO KITA') }}
                </span>
            </div>

            <nav class="hidden md:flex space-x-8 text-sm font-medium items-center">
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-indigo-900 transition {{ request()->routeIs('home') ? 'text-indigo-900 font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="text-slate-600 hover:text-indigo-900 transition {{ request()->routeIs('products.*') ? 'text-indigo-900 font-semibold' : '' }}">Katalog Produk</a>
                @auth
                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('customer.password.edit') }}" class="text-slate-600 hover:text-indigo-900 transition {{ request()->routeIs('customer.password.*') ? 'text-indigo-900 font-semibold' : '' }}">Ganti Password</a>
                    @endif
                @endauth
            </nav>

            <div class="hidden md:flex items-center gap-5 text-sm font-medium">
                @auth
                    @if (Auth::user()->role === 'customer')
                        <a href="{{ route('cart.index') }}" class="text-slate-500 hover:text-indigo-900 relative p-1.5 rounded-full hover:bg-slate-50 transition" title="Keranjang Belanja">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span id="nav-cart-badge" class="absolute -top-0.5 -right-0.5 bg-indigo-600 text-white font-bold text-[9px] w-4 h-4 rounded-full flex items-center justify-center border border-white shadow-xs">
                                0
                            </span>
                        </a>
                    @endif

                    <a href="{{ route('customer.dashboard') }}" class="text-slate-600 hover:text-indigo-900 flex items-center gap-1.5 bg-slate-100 px-3 py-1.5 rounded-md border border-slate-200">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ Auth::user()->name }}
                    </a>

                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'cashier')
                        <a href="{{ route('admin.dashboard') }}" class="text-amber-700 hover:text-amber-900 transition flex items-center gap-1 bg-amber-50 border border-amber-200 px-2.5 py-1.5 rounded-md text-xs">
                            Panel Staf
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun pelanggan Anda?');" class="inline">
                        @csrf
                        <button type="submit" class="text-rose-600 hover:text-rose-800 transition cursor-pointer font-medium text-xs flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-900 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-indigo-900 text-white px-4 py-2 rounded-md hover:bg-indigo-950 transition shadow-sm">Daftar</a>
                @endauth
            </div>

            <div class="flex items-center gap-4 md:hidden">
                @auth
                    @if (Auth::user()->role === 'customer')
                        <a href="{{ route('cart.index') }}" class="text-slate-500 relative p-1.5 rounded-full hover:bg-slate-50 transition" title="Keranjang Belanja">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span id="nav-cart-badge-mobile" class="absolute -top-0.5 -right-0.5 bg-indigo-600 text-white font-bold text-[9px] w-4 h-4 rounded-full flex items-center justify-center border border-white shadow-xs">
                                0
                            </span>
                        </a>
                    @endif
                @endauth

                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-slate-600 hover:text-indigo-900 p-1 rounded-md focus:outline-none transition cursor-pointer" title="Buka Menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden border-b border-slate-200 bg-white shadow-inner">
        <div class="px-4 pt-2 pb-4 space-y-2 text-xs font-semibold text-slate-700">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50 transition">Beranda</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50 transition">Katalog Produk</a>
            @auth
                @if(Auth::user()->role === 'customer')
                    <a href="{{ route('customer.password.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50 transition">Ganti Password</a>
                @endif
            @endauth
            
            <div class="h-px bg-slate-100 my-2"></div>

            @auth
                <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 rounded-lg bg-slate-50 text-indigo-950 font-bold border border-slate-200 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Akun: {{ Auth::user()->name }}
                </a>

                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'cashier')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg bg-amber-50 text-amber-800 font-bold border border-amber-200">
                        Masuk Panel Staf
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun pelanggan Anda?');" class="block pt-1">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg bg-rose-50 text-rose-700 border border-rose-100 font-bold flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar Aplikasi
                    </button>
                </form>
            @else
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-lg bg-slate-100 font-bold text-slate-700 block border border-slate-200">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-lg bg-indigo-900 font-bold text-white block">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function refreshNavbarBadges() {
            let badgeDesktop = document.getElementById('nav-cart-badge');
            let badgeMobile = document.getElementById('nav-cart-badge-mobile');
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let totalItem = cart.reduce((total, item) => total + item.quantity, 0);

            if (badgeDesktop) badgeDesktop.innerText = totalItem;
            if (badgeMobile) badgeMobile.innerText = totalItem;
        }

        refreshNavbarBadges();
        window.updateNavbarBadgeDirectly = refreshNavbarBadges;
    });
</script>