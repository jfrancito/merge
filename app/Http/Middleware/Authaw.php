<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class Authaw
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('empresas')) {
            if (!Session::has('usuario')) {
                return redirect()->to('/login');
            } else {
                return redirect()->to('/acceso');
            }
        } else {
            if (Session::has('usuario')) {
                $usuario = User::where('id', '=', Session::get('usuario')->id)
                    ->where('activo', '=', 1)->first();
                if (!$usuario) {
                    Session::forget('usuario');
                    Session::forget('listamenu');
                    Session::forget('empresas');
                    Session::forget('listaopciones');
                    Session::forget('color');
                    return redirect()->to('/login');
                }

                return $next($request);
            } else {
                return redirect()->to('/login');
            }
        }
    }
}
