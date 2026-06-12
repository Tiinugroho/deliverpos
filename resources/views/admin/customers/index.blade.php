@extends('layouts.admin')

@section('title', 'Katalog Pelanggan')

@section('content')
    <div class="w-full space-y-4">
        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-sm flex items-center gap-2">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="pt-2">
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Akun Pelanggan Terdaftar</h1>
            <p class="text-xs text-slate-400 mt-0.5">Seluruh data di bawah ini terkumpul secara otomatis melalui form registrasi mandiri pelanggan.</p>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 w-full">
            <div class="overflow-x-auto w-full">
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Pelanggan</th>
                            <th class="py-3.5 px-4">Email Aktif</th>
                            <th class="py-3.5 px-4 text-center">No. WhatsApp</th>
                            <th class="py-3.5 px-4">Alamat Default</th>
                            <th class="py-3.5 px-4 text-center w-48">Aksi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ $customer->name }}</td>
                                <td class="py-3.5 px-4 font-medium text-slate-600">{{ $customer->email }}</td>
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $customer->phone_number ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-slate-500 truncate max-w-xs">{{ $customer->address ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        
                                        <form action="{{ route('admin.customers.reset', $customer->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin me-reset sandi pelanggan ini menjadi: pelanggan123 ?');" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px] cursor-pointer">
                                                Reset Sandi
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen akun pelanggan ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px] cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-medium">Belum ada akun konsumen/pelanggan yang terdaftar di dalam sistem.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection