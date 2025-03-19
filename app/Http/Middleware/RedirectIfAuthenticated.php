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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirection basée sur le rôle de l'utilisateur
                if (Auth::user()->role === 'admin') {
                    return redirect('/dashboard/admin');
                }
                return redirect('/'); // Redirection par défaut pour les autres utilisateurs
            }
        }

        return $next($request);
    }
}
