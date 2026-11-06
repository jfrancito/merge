<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;
use App\Facades\Hashids as HashidsFacade;

class HashidsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrar singleton con los parámetros originales de Torann\Hashids
        $this->app->singleton('hashids', function ($app) {
            $config = $app['config']->get('hashids');

            $salt = $config['salt'] ?? '';
            $length = $config['length'] ?? 0;
            $alphabet = $config['alphabet'] ?? '';

            if (empty($alphabet)) {
                return new Hashids($salt, $length);
            }

            return new Hashids($salt, $length, $alphabet);
        });
    }

    public function boot()
    {
        // Registrar alias manualmente (Laravel 11 ya no tiene withAliases)
        if (!class_exists('Hashids')) {
            class_alias(HashidsFacade::class, 'Hashids');
        }
    }
}
