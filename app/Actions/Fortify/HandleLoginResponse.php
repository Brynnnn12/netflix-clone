<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Auth;

class HandleLoginResponse
{
    /**
     * Handle the response after a user authenticates.
     *
     * @return string
     */
    public function redirect(): string
    {
        $user = Auth::user();

        // Redirect admin ke Filament
        if ($user->hasRole(['admin', 'super_admin'])) {
            return '/admin';
        }

        // Redirect user biasa ke dashboard
        return '/dashboard';
    }
}
