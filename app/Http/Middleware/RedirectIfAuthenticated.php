<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('home');
                }
            break;
            case 'peserta':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('ujian');
                }
            break;
            case 'peserta-sim':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('ujian-sim');
                }
            break;
            case 'peserta-skb':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('ujian-skb');
                }
            break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/');
                }
            break;
        }

        return $next($request);
    }
}
