<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class ForceCorrectProtocol
{
    public function handle($request, Closure $next)
    {
        // Detectar si la petición viene de la red local
        $host = $request->getHost();
        $ip = $request->ip();
        
        // Lista de IPs locales o dominios locales
        $localHosts = [
            '10.1.50.2',
            'localhost',
            '127.0.0.1',
        ];
        
        // Verificar si es una IP local o contiene el puerto 8080
        $isLocal = in_array($host, $localHosts) || 
                   strpos($host, '10.1.50.2') !== false ||
                   strpos($request->server('HTTP_HOST'), ':8080') !== false;
        
        if ($isLocal) {
            // Entorno local: forzar HTTP en el puerto 8080
            if (!$request->secure()) {
                // Ya está en HTTP, no hacer nada
            }
        } else {
            // Entorno público (Cloudflare): forzar HTTPS
            if (!$request->secure()) {
                $secureUrl = str_replace('http://', 'https://', $request->fullUrl());
                return redirect()->to($secureUrl, 301);
            }
            
            // Forzar que todas las URLs generadas usen HTTPS
            URL::forceScheme('https');
        }
        
        return $next($request);
    }
}