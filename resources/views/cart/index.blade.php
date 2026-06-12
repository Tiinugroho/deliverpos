@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="space-y-8">
        <div class="border-b border-slate-200 pb-4">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Keranjang Belanja Kamu</h1>
            <p class="text-xs text-slate-500 mt-0.5">Periksa kembali daftar barang pesanan sebelum melakukan checkout.</p>
        </div>

        <div id="cart-empty"
            class="hidden bg-white border border-slate-200 p-12 text-center rounded-xl text-xs text-slate-400 space-y-3 shadow-xs">
            <svg class="w-12 h-12 mx-auto text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <p class="font-medium text-slate-600 text-sm">Keranjang belanja kamu masih kosong</p>
            <p class="font-light max-w-xs mx-auto">Yuk, lihat produk pilihan kami terlebih dahulu dan tambahkan ke
                keranjang.</p>
            <div class="pt-2">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center gap-1 bg-indigo-900 hover:bg-indigo-950 text-white font-semibold py-2 px-4 rounded-md text-xs transition shadow-xs cursor-pointer">
                    Lihat Katalog Produk
                </a>
            </div>
        </div>

        <div id="cart-main" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 text-xs">
                                <th class="px-6 py-3">Produk</th>
                                <th class="px-6 py-3 text-center">Harga</th>
                                <th class="px-6 py-3 text-center">Jumlah</th>
                                <th class="px-6 py-3 text-center">Subtotal</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-container" class="divide-y divide-slate-150">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs space-y-6">
                <h2 class="text-sm font-bold text-indigo-950 uppercase tracking-wide border-b border-slate-100 pb-3">
                    Ringkasan Pesanan</h2>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>Total Barang</span>
                        <span id="summary-qty" class="font-medium text-slate-800">0 Item</span>
                    </div>
                    <div class="border-t border-slate-100 pt-3 flex justify-between font-bold text-sm text-slate-900">
                        <span>Total Harga</span>
                        <span id="summary-total">Rp 0</span>
                    </div>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" id="form-checkout"
                    onsubmit="return confirm('Apakah Anda yakin ingin memproses pemesanan makanan ini? Mohon pastikan alamat katering sudah benar.');"
                    class="space-y-4 pt-2 border-t border-slate-100">
                    @csrf
                    <div id="hidden-inputs-container"></div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700">Alamat Lengkap Pengiriman</label>
                        <textarea name="shipping_address" rows="3" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition resize-none">{{ Auth::user()->address ?? '' }}</textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700">Catatan Tambahan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Contoh: Rumah katering pagar hitam / titip satpam"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-900 hover:bg-indigo-950 text-white font-semibold py-2.5 px-4 rounded-md text-xs transition flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                        Proses Pemesanan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            renderCart();

            function renderCart() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                const emptySection = document.getElementById('cart-empty');
                const mainSection = document.getElementById('cart-main');
                const itemsContainer = document.getElementById('cart-items-container');
                const hiddenInputsContainer = document.getElementById('hidden-inputs-container');

                itemsContainer.innerHTML = "";
                hiddenInputsContainer.innerHTML = "";

                if (cart.length === 0) {
                    emptySection.classList.remove('hidden');
                    mainSection.classList.add('hidden');
                    return;
                }

                emptySection.classList.add('hidden');
                mainSection.classList.remove('hidden');

                let totalHargaAll = 0;
                let totalQtyAll = 0;

                cart.forEach((item, index) => {
                    let subtotal = item.price * item.quantity;
                    totalHargaAll += subtotal;
                    totalQtyAll += item.quantity;

                    let tr = document.createElement('tr');
                    tr.className = "hover:bg-slate-50/50 transition text-xs text-slate-700";
                    tr.innerHTML = `
                    <td class="px-6 py-4 font-semibold text-slate-900">${item.name}</td>
                    <td class="px-6 py-4 text-center text-slate-500">Rp ${formatRupiah(item.price)}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="btn-minus bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-2 py-0.5 rounded border border-slate-200 transition cursor-pointer" data-index="${index}">-</button>
                            <span class="font-semibold w-6 text-center">${item.quantity}</span>
                            <button type="button" class="btn-plus bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-2 py-0.5 rounded border border-slate-200 transition cursor-pointer" data-index="${index}">+</button>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center font-semibold text-slate-800">Rp ${formatRupiah(subtotal)}</td>
                    <td class="px-6 py-4 text-center">
                        <button type="button" class="btn-delete text-rose-600 hover:text-rose-800 transition cursor-pointer" data-index="${index}">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                    `;
                    itemsContainer.appendChild(tr);

                    hiddenInputsContainer.innerHTML += `
                        <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    `;
                });

                document.getElementById('summary-qty').innerText = `${totalQtyAll} Item`;
                document.getElementById('summary-total').innerText = `Rp ${formatRupiah(totalHargaAll)}`;

                initActionButtons();
            }

            function initActionButtons() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                document.querySelectorAll('.btn-plus').forEach(button => {
                    button.onclick = function() {
                        let index = this.dataset.index;
                        cart[index].quantity++;
                        localStorage.setItem('cart', JSON.stringify(cart));
                        renderCart();
                        updateNavbarBadgeDirectly();
                    };
                });

                document.querySelectorAll('.btn-minus').forEach(button => {
                    button.onclick = function() {
                        let index = this.dataset.index;
                        if (cart[index].quantity > 1) {
                            cart[index].quantity--;
                            localStorage.setItem('cart', JSON.stringify(cart));
                            renderCart();
                            updateNavbarBadgeDirectly();
                        }
                    };
                });

                // GANTI POTONGAN KODE TOMBOL DELETE LAMA ANDA DENGAN INI:
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.onclick = function() {
                        let index = this.dataset.index;

                        // PERBAIKAN: Memanggil Modal Tailwind secara langsung tanpa alert browser!
                        window.askConfirmation(
                            'Hapus menu kuliner ini dari dalam daftar keranjang belanja Anda?',
                            function() {
                                // Kode di bawah ini hanya akan berjalan jika user mengklik "Ya, Konfirmasi" di Modal
                                cart.splice(index, 1);
                                localStorage.setItem('cart', JSON.stringify(cart));
                                renderCart();
                                updateNavbarBadgeDirectly();

                                if (typeof toastr !== 'undefined') {
                                    toastr.success('Menu berhasil dihapus dari keranjang.');
                                }
                            });
                    };
                });
            }

            // Ganti fungsi updateNavbarBadgeDirectly() lama di file cart.index menjadi ini:
            function updateNavbarBadgeDirectly() {
                if (typeof window.updateNavbarBadgeDirectly === 'function') {
                    window.updateNavbarBadgeDirectly(); // Memanggil fungsi badge terpadu milik navbar
                }
            }

            // OTOMATISASI: Kosongkan keranjang di localStorage saat form checkout berhasil lolos kirim
            document.getElementById('form-checkout').addEventListener('submit', function() {
                localStorage.removeItem('cart');
            });

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }
        });
    </script>
@endsection
