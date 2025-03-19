<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Restrict
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            return redirect('/login')->with('error', 'Accès non autorisé.');
        }
        return $next($request);
    }
}
