<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Validator;
use View;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!class_exists('Form')) {
            class_alias(\App\Biblioteca\Form::class, 'Form');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Detectar dinámicamente si estamos tras un proxy seguro (como Cloudflare) o en HTTPS local
        if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1 || $_SERVER['HTTPS'] === '1')) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        View::share('carpeta', '/merge');
        View::share('capeta', '/merge');
        View::share('version', '1');
        View::share('vapp', '2026.03.18.01');

        Blade::componentNamespace('App\\View\\Components\\Form', 'form');

        // Compartir lista de empresas con el header
        \Illuminate\Support\Facades\View::composer('partials.header', function ($view) {
            if (session()->has('usuario')) {
                $usuario = session('usuario');

                // 1. Si es Super Admin, ve todas las empresas del sistema
                if ($usuario->id === '1CIX00000001' || $usuario->rol_id === '1CIX00000001') {
                    $view->with('todas_empresas', \App\Models\Empresa::orderBy('nombre', 'asc')->get());
                }
                // 2. Si tiene código de vinculación/holding, ve las del holding + las de sus usuarios gemelos vinculados
                elseif (!empty($usuario->codigo_holding)) {
                    $empresaActual = session('empresa');
                    $config = $empresaActual->configuracion ?? [];
                    $empIds = [$empresaActual->id];

                    if (isset($config['holding_importador']['empresas_asociadas'])) {
                        $empIds = array_merge($empIds, collect($config['holding_importador']['empresas_asociadas'])->pluck('empresa_id')->toArray());
                    }

                    // Buscar todas las empresas que tienen un usuario activo con el mismo codigo_holding (gemelos)
                    $gemeloEmpIds = \App\Models\User::withoutGlobalScope('empresa')
                        ->where('codigo_holding', $usuario->codigo_holding)
                        ->where('activo', 1)
                        ->pluck('empresa_id')
                        ->toArray();

                    $empIds = array_unique(array_merge($empIds, $gemeloEmpIds));

                    $empresasHolding = \App\Models\Empresa::whereIn('id', $empIds)->orderBy('nombre', 'asc')->get();
                    $view->with('todas_empresas', $empresasHolding);
                }
            }
        });
    }
}
