<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Guestaw
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('usuario')) {
            return $next($request);
        } else {
            if (!Session::has('empresas')) {
                return $next($request);
            } else {
                return redirect()->to('/bienvenido');
            }
        }
    }
}
