<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Part-12.5: "a suspended institution's users are immediately locked out (checked at
 * auth-middleware level, not just hidden in UI)."
 */
class EnsureInstitutionActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ! $user->isActive()) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Your account or institution is not active. Please contact your administrator.',
            ]);
        }

        return $next($request);
    }
}
