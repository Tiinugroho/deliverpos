@extends('layouts.app')

@section('title', 'Login Pengguna')

@section('content')
<div class="max-w-md mx-auto my-12">
    <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-xs space-y-6">
        
        <div class="text-center space-y-2">
            <div class="inline-flex p-3 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-900 mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Silahkan Login</h1>
            <p class="text-xs text-slate-500">Masukkan email dan password akun kamu untuk masuk ke sistem.</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 p-3 rounded text-rose-800 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p class="font-medium">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Masukkan email kamu" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="password" class="text-xs font-semibold text-slate-700">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" required placeholder="Masukkan password kamu" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-700 transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-900 hover:bg-indigo-950 text-white text-xs font-semibold py-2.5 rounded-md transition shadow-xs cursor-pointer flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 01-3-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">Daftar akun baru di sini</a>
            </p>
        </div>

    </div>
</div>
@endsection