<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Rolemiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek User apakah sudah login? 
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu!');
        }


        // 2. Cek apakah User memiliki role tertentu (jika diperlukan)
        $userRole = Auth::user()->role; // Ambil role user yang sedang login
        if(in_array($userRole, $roles)){
            return $next($request);
        }
        // 3. Jika user tidak memiliki role yang sesuai, bisa redirect atau tampilkan error
        abort(403, 'Anda tidak memiliki akses ke halaman ini!');
    }
}
