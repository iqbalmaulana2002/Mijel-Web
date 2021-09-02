<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $level)
    {
        if ($request->user()->is_active === 0) {
            Auth::logout();
            return redirect('/login')->with('pesanError', 'Akun anda sudah di nonaktifkan');
        }

        if ($request->user()->level == $level) {
            return $next($request);
        } else {
            if (auth()->user()->level == 'admin') {
                return redirect('/admin');
            } elseif (auth()->user()->level == 'petugas') {
                return redirect('/petugas');
            } else {
                return redirect('/anggota');
            }
        }
    }
}
