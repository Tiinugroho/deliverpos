<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Corporate Order System') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    @include('layouts.components.navbar')

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-8">
        @yield('content')
    </main>

    <footer class="bg-indigo-950 text-slate-400 py-6 border-t border-indigo-900 mt-auto text-xs">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                &copy; {{ date('Y') }} <strong>{{ config('app.name', 'CorpSystem') }}</strong>.
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    <div id="globalConfirmModal"
        class="fixed inset-0 z-[999] hidden items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm transition-all">
        <div
            class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 max-w-sm w-full space-y-4 scale-95 transition-all">
            <div class="flex items-center gap-3 text-amber-600">
                <div
                    class="h-10 w-10 bg-amber-50 rounded-xl flex items-center justify-center border border-amber-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Konfirmasi Tindakan</h3>
            </div>
            <p id="globalConfirmMessage" class="text-xs text-slate-500 leading-relaxed font-medium">Apakah Anda yakin
                ingin melanjutkan tindakan ini?</p>
            <div class="flex justify-end gap-2 pt-2 text-xs font-semibold">
                <button id="btnGlobalConfirmCancel"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl transition cursor-pointer">Batal</button>
                <button id="btnGlobalConfirmSubmit"
                    class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl transition shadow-sm cursor-pointer">Ya,
                    Konfirmasi</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // --------------------------------------------------------
            // 1. CONFIGURATION TOASTR NOTIFIKASI GLOBAL
            // --------------------------------------------------------
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000", // Tampil pas 3 detik
                "extendedTimeOut": "1000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}", "Berhasil!");
            @endif
            @if (session('error'))
                toastr.error("{{ session('error') }}", "Gagal!");
            @endif

            // --------------------------------------------------------
            // 2. LOGIKA INTERCEPTOR MODAL UNTUK FORM & JAVASCRIPT MANUAL
            // --------------------------------------------------------
            var targetedForm = null;
            var customCallback = null; // Wadah penyimpan aksi dari script JavaScript manual

            // Fungsi Jembatan Baru agar bisa dipanggil langsung dari script JS biasa
            window.askConfirmation = function(message, callback) {
                targetedForm = null;
                customCallback = callback; // Simpan fungsi yang akan dijalankan jika klik setuju

                $('#globalConfirmMessage').text(message);
                $('#globalConfirmModal').removeClass('hidden').addClass('flex');
            };

            // Bersihkan seluruh form onsubmit bawaan saat halaman dimuat
            $('form').each(function() {
                var inlineOnsubmit = $(this).attr('onsubmit');
                if (inlineOnsubmit && inlineOnsubmit.includes('confirm')) {
                    var matches = inlineOnsubmit.match(/confirm\(['"](.*?)['"]\)/);
                    if (matches && matches[1]) {
                        $(this).attr('data-confirm', matches[1]);
                        $(this).removeAttr('onsubmit');
                    }
                }
            });

            // Tangkap event submit untuk Form HTML
            $(document).on('submit', 'form', function(e) {
                var formInstance = this;
                if ($(formInstance).data('modal-approved')) {
                    return true;
                }

                var confirmationMessage = $(formInstance).attr('data-confirm');
                if (confirmationMessage) {
                    e.preventDefault();
                    targetedForm = formInstance;
                    customCallback = null;

                    $('#globalConfirmMessage').text(confirmationMessage);
                    $('#globalConfirmModal').removeClass('hidden').addClass('flex');
                }
            });

            // Aksi ketika tombol "Batal" di klik pada Modal
            $('#btnGlobalConfirmCancel').on('click', function() {
                $('#globalConfirmModal').removeClass('flex').addClass('hidden');
                targetedForm = null;
                customCallback = null;
            });

            // Aksi ketika tombol "Ya, Konfirmasi" di klik pada Modal
            $('#btnGlobalConfirmSubmit').on('click', function() {
                $('#globalConfirmModal').removeClass('flex').addClass('hidden');

                if (targetedForm) {
                    // Jika pemicunya adalah Form HTML
                    $(targetedForm).data('modal-approved', true);
                    targetedForm.submit();
                } else if (customCallback) {
                    // Jika pemicunya adalah Script JavaScript biasa (seperti hapus keranjang)
                    customCallback();
                }

                targetedForm = null;
                customCallback = null;
            });
        });
    </script>
</body>

</html>
