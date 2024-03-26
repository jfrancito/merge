<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Guestaw {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!Session::has('usuario')) {
            return $next($request);
        } else {
            return Redirect()->to('/bienvenido');
        }
    }
}
