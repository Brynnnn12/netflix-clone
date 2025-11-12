<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasActiveSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $movie = $request->route('movie');

        if ($movie && $movie->is_premium) {
            $user = Auth::user();

            if (!$user || !$user->canWatchPremium()) {
                return redirect()->route('subscription.plans')
                    ->with('error', 'Anda perlu berlangganan untuk menonton konten ini');
            }
        }

        return $next($request);
    }
}
