<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;
use App\Facades\Hashids as HashidsFacade;

class HashidsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrar singleton
        $this->app->singleton('hashids', function () {
            return new Hashids(config('app.key') ?: 'default-salt-string-for-hashids', 8);
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
