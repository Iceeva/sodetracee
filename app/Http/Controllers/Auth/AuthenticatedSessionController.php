<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// class AuthenticatedSessionController extends Controller
// {
//     /**
//      * Display the login view.
//      */
//     public function create(): View
//     {
//         return view('auth.login');
//     }

//     protected function redirectTo() {
//         if (session('redirect')) {
//             return session('redirect');
//         }
//         return route('welcome');
//     }

//     /**
//      * Handle an incoming authentication request.
//      */
//     public function store(LoginRequest $request)
//     {
//         $request->authenticate();
//     $request->session()->regenerate();
//     dd(Auth::user()->role); // Vérifie le rôle avant redirection
//     if (Auth::user()->role === 'admin') {
//         return redirect('/dashboard/admin');
//     }

//         return redirect('/'); // Redirige les autres utilisateurs vers la racine
//     }

//     /**
//      * Destroy an authenticated session.
//      */
//     public function destroy(Request $request): RedirectResponse
//     {
//         Auth::guard('web')->logout();

//         $request->session()->invalidate();

//         $request->session()->regenerateToken();

//         return redirect('/');
//     }
// }

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin'); // Redirection vers /dashboard/admin
        }
        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}