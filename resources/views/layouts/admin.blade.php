<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: true, mobileSidebarOpen: false, profileDropdown: false, notificationDropdown: false, activeModal: null, selectedApplicant: {} }" x-init="document.body.classList.remove('loading-state')">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Corporate Order System') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/buttons.dataTables.min.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ url('assets/icon/OIP.ico') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Kunci layout secara instan menggunakan CSS murni selama 'loading-state' aktif */
        body.loading-state .hidden {
            display: none !important;
        }

        body.loading-state .-translate-x-full {
            transform: translateX(-100%) !important;
        }

        @media (min-width: 1024px) {
            body.loading-state .lg\:flex {
                display: flex !important;
                width: 280px !important;
            }

            body.loading-state .lg\:pl-\[280px\] {
                padding-left: 280px !important;
            }
        }
    </style>
</head>

<body class="text-slate-700 antialiased overflow-x-hidden min-h-screen bg-[#f4f8fa] loading-state">

    <div
        class="fixed top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-[#C4E2F5]/40 blur-[130px] pointer-events-none z-0">
    </div>
    <div
        class="fixed bottom-[-10%] right-[-10%] w-[40vw] h-[40vw] rounded-full bg-[#4BB8FA]/20 blur-[110px] pointer-events-none z-0">
    </div>

    @include('admin.components.sidebar')

    <div class="flex-1 flex flex-col min-h-screen z-10 w-full transition-all duration-300 min-w-0 lg:pl-[280px]"
        :class="sidebarOpen ? 'lg:pl-[280px]' : 'lg:pl-[88px]'">

        @include('admin.components.header')

        <div class="flex flex-col xl:flex-row flex-1 p-4 lg:p-8 gap-6 w-full max-w-[100vw]">
            <div class="flex-1 space-y-6 min-w-0 w-full">
                @include('admin.components.breadcrumbs')
                @yield('content')
            </div>
        </div>
    </div>

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
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Verifikasi Aksi</h3>
            </div>
            <p id="globalConfirmMessage" class="text-xs text-slate-500 leading-relaxed font-medium">Apakah Anda
                benar-benar yakin ingin mengeksekusi operasional tindakan ini?</p>
            <div class="flex justify-end gap-2 pt-2 text-xs font-semibold">
                <button id="btnGlobalConfirmCancel"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl transition cursor-pointer">Batal</button>
                <button id="btnGlobalConfirmSubmit"
                    class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2.5 rounded-xl transition shadow-sm cursor-pointer">Ya,
                    Lanjutkan</button>
            </div>
        </div>
    </div>

    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('assets/js/jszip.min.js') }}"></script>
    <script src="{{ url('assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ url('assets/js/vfs_fonts.js') }}"></script>
    <script src="{{ url('assets/js/buttons.html5.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // --------------------------------------------------------
            // 1. CONFIGURATION TOASTR NOTIFIKASI GLOBAL (Tampil 3 Detik)
            // --------------------------------------------------------
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000", // Pas 3 detik langsung hilang
                "extendedTimeOut": "1000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Menangkap otomatis session flash dari Laravel Controller
            @if (session('success'))
                toastr.success("{{ session('success') }}", "Berhasil!");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", "Gagal!");
            @endif

            // --------------------------------------------------------
            // 2. LOGIKA INTERCEPTOR: SEAMLESS REPLACEMENT (HANYA MODAL YANG KELUAR)
            // --------------------------------------------------------
            var targetedForm = null;

            // TRIK PINTAR: Saat halaman selesai dimuat, bersihkan semua onsubmit bawaan secara global
            $('form').each(function() {
                var inlineOnsubmit = $(this).attr('onsubmit');

                // Jika form kedapatan masih pakai confirm bawaan javascript
                if (inlineOnsubmit && inlineOnsubmit.includes('confirm')) {
                    var matches = inlineOnsubmit.match(/confirm\(['"](.*?)['"]\)/);
                    if (matches && matches[1]) {
                        // Pindahkan teks pesannya ke dalam data-confirm custom
                        $(this).attr('data-confirm', matches[1]);
                        // HAPUS UTUH attribute onsubmit aslinya agar browser tidak memicu pop-up putih
                        $(this).removeAttr('onsubmit');
                    }
                }
            });

            // Tangkap event submit yang sekarang sudah bersih dari native confirm
            $(document).on('submit', 'form', function(e) {
                var formInstance = this;

                // Jika form sudah disetujui lewat Modals Tailwind, ijinkan lolos langsung ke Controller
                if ($(formInstance).data('modal-approved')) {
                    return true;
                }

                var confirmationMessage = $(formInstance).attr('data-confirm');

                // Jika form ini membutuhkan konfirmasi, tahan dulu dan munculkan Modal cantik kita
                if (confirmationMessage) {
                    e.preventDefault(); // Stop halaman agar tidak refresh
                    targetedForm = formInstance; // Simpan form yang sedang aktif

                    // Masukkan teks ke dalam Modals Tailwind dan tampilkan ke layar
                    $('#globalConfirmMessage').text(confirmationMessage);
                    $('#globalConfirmModal').removeClass('hidden').addClass('flex');
                }
            });

            // Jika klik Batal di Modals Tailwind
            $('#btnGlobalConfirmCancel').on('click', function() {
                $('#globalConfirmModal').removeClass('flex').addClass('hidden');
                targetedForm = null;
            });

            // Jika klik "Ya, Lanjutkan" di Modals Tailwind
            $('#btnGlobalConfirmSubmit').on('click', function() {
                if (targetedForm) {
                    // Tandai bahwa form ini sudah disetujui lewat sensor modal
                    $(targetedForm).data('modal-approved', true);
                    // Kirim form langsung ke database
                    targetedForm.submit();
                }
                $('#globalConfirmModal').removeClass('flex').addClass('hidden');
            });

            // --------------------------------------------------------
            // 3. INITIALIZATION DATATABLES ENGINE
            // --------------------------------------------------------
            $('.datatable-init').each(function() {
                var $table = $(this);
                var tableInstance = $table.DataTable({
                    responsive: true,
                    dom: 'lfrtip',
                    pageLength: 10,
                    lengthMenu: [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Semua"]
                    ],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Filter cari data...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                        zeroRecords: "Data tidak ditemukan",
                        paginate: {
                            next: '→',
                            previous: '←'
                        }
                    }
                });

                new $.fn.dataTable.Buttons(tableInstance, {
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Data Ekspor Sistem'
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Data Ekspor Sistem'
                        }
                    ]
                });

                var $container = $table.closest('.glass-card, .bg-white, .space-y-6');

                $container.find('.btn-export-excel').on('click', function() {
                    tableInstance.button('.buttons-excel').trigger();
                });

                $container.find('.btn-export-pdf').on('click', function() {
                    tableInstance.button('.buttons-pdf').trigger();
                });
            });
        });
    </script>
</body>

</html>
