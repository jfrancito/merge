<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;
use View;
use Illuminate\Support\Facades\DB;
use App\User, App\WEBGrupoopcion, App\WEBRol, App\WEBRolOpcion, App\WEBOpcion;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::share('capeta', '/merge');

        View::share('version', '19.26');


        View::share('titulo', '');

        if (config('app.env') === 'production' && !request()->is('10.1.50.2*')) {
            URL::forceScheme('https');
            $this->app['url']->forceScheme('https'); // Esto fuerza también asset()
        }

        // Forzar que asset() genere URLs relativas en entorno local
        if (request()->getHost() === '10.1.50.2' || 
            request()->getHost() === 'localhost' ||
            strpos(request()->getHost(), '10.1.50.2') !== false) {
            
            // En local: reemplazar la raíz de las URLs por vacío para que sean relativas
            \URL::forceRootUrl('');
            
            // También forzar el esquema HTTP
            if (!request()->secure()) {
                \URL::forceScheme('http');
            }
        } else {
            // En producción: forzar HTTPS
            \URL::forceScheme('https');
        }

        Validator::extend('unico', function ($attribute, $value, $parameters, $validator) {
            $tabla = $parameters[0] . '.' . $parameters[1];
            $count = DB::table($tabla)->where($attribute, '=', $value)->count();
            if ($count > 0) {
                return false;
            } else {
                return true;
            }
        });


        Validator::extend('unico_menos', function ($attribute, $value, $parameters, $validator) {

            $tabla = $parameters[0] . '.' . $parameters[1];
            $attr = $parameters[2];
            $valor = $parameters[3];

            $count = DB::table($tabla)->where($attribute, '=', $value)->where($attr, '<>', $valor)->count();

            if ($count > 0) {
                return false;
            } else {
                return true;
            }

        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
