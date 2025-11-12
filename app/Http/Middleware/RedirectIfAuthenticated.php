<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $redirectIfAuthenticated
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect berdasarkan role user
                $user = Auth::guard($guard)->user();

                // Jika user adalah admin, redirect ke Filament admin panel
                if ($user->hasRole('admin')) {
                    return redirect()->to('/admin');
                }

                // Jika user adalah super admin
                if ($user->hasRole('super_admin')) {
                    return redirect()->to('/admin');
                }

                // User biasa redirect ke dashboard
                return redirect()->to('/dashboard');
            }
        }

        return $next($request);
    }
}
