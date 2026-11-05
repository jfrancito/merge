<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarUsuario
{


    public function handle($request, Closure $next)
    {
        if (!auth()->check() && !session('usuario_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }



}
