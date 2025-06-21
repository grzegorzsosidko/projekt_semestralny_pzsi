<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- TO JEST KLUCZOWA, BRAKUJĄCA LINIA

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sprawdź, czy użytkownik jest zalogowany I czy jego rola to 'administrator'
        if (Auth::check() && Auth::user()->role == 'administrator') {
            // Jeśli tak, pozwól mu przejść dalej
            return $next($request);
        }

        // Jeśli nie, przekieruj go na stronę główną (dashboard)
        return redirect()->route('dashboard');
    }
}
