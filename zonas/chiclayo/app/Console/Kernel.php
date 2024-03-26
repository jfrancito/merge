<?php

namespace App\Console;

use App\Console\Commands\DesactivarReglas;
use App\Console\Commands\ServicioDelivery;
use App\Console\Commands\RedesSociales;
use App\Console\Commands\AlertaDesactivarReglas;
use App\Console\Commands\PedidoNotificacionVendedor;
use App\Console\Commands\PedidoNotificacionAutorizar;
use App\Console\Commands\PedidoNotificacionDespacho;
use App\Console\Commands\PedidoNotificacionRechazado;

use App\Console\Commands\CampanaUtiles;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DesactivarReglas::class,
        RedesSociales::class,
        AlertaDesactivarReglas::class,
        ServicioDelivery::class,
        PedidoNotificacionVendedor::class,
        PedidoNotificacionAutorizar::class,
        PedidoNotificacionDespacho::class,
        PedidoNotificacionRechazado::class,
        CampanaUtiles::class

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //$schedule->command('campana:utiles')->dailyAt('09:30');


        //$schedule->command('servicio:delivery')->dailyAt('14:00');
        $schedule->command('pedidonotificacion:despacho')->everyMinute(); // CADA MINUTO
        $schedule->command('pedidonotificacion:autorizar')->everyMinute(); // CADA MINUTO
        $schedule->command('pedidonotificacion:vendedor')->everyMinute(); // CADA MINUTO
        $schedule->command('pedidonotificacion:rechazado')->everyMinute(); // CADA MINUTO
        $schedule->command('desactivarreglas:desactivarreglasContrato')->everyMinute(); // CADA MINUTO
        $schedule->command('alertadesactivarreglas:desactivarreglasmanana')->dailyAt('08:00');
        //$schedule->command('redessociales:publicidadredessociales')->dailyAt('13:59');
        //$schedule->command('redessociales:publicidadredessociales')->dailyAt('15:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
