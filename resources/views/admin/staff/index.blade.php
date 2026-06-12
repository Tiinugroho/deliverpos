@extends('layouts.admin')

@section('title', 'Manajemen Karyawan')

@section('content')
    <div class="w-full space-y-4">
        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-sm">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 shadow-sm">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center flex-wrap gap-4 pt-2">
            <h1 class="text-lg font-bold text-slate-900 tracking-tight">Manajemen Akun Karyawan / Staff</h1>
            <a href="{{ route('admin.staff.create') }}" 
               class="bg-[#2C5EAD] hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Tambah Karyawan Baru
            </a>
        </div>

        <div class="glass-card bg-white rounded-3xl p-4 lg:p-6 shadow-sm border border-slate-100 w-full">
            <div class="overflow-x-auto w-full">
                <table class="datatable-init w-full text-left text-xs border-collapse table-border">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Lengkap</th>
                            <th class="py-3.5 px-4">Alamat Email</th>
                            <th class="py-3.5 px-4 text-center">Nomor HP</th>
                            <th class="py-3.5 px-4 text-center">Otoritas / Role</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 text-slate-700">
                        @foreach($staffs as $staff)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ $staff->name }}</td>
                                <td class="py-3.5 px-4 font-medium text-slate-600">{{ $staff->email }}</td>
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ $staff->phone_number ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($staff->role === 'admin')
                                        <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-0.5 rounded-md font-bold text-[10px] uppercase tracking-wide">Owner / Admin</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-700 border border-slate-200 px-2.5 py-0.5 rounded-md font-semibold text-[10px] uppercase tracking-wide">Kasir / Staff</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.staff.edit', $staff->id) }}"
                                           class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px]">
                                            Ubah
                                        </a>
                                        
                                        @if(auth()->id() !== $staff->id)
                                            <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun staff ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1.5 rounded-lg font-semibold transition text-[11px] cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-400 italic font-medium px-2">Akun Aktif</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection