<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use DateTime;
use App\Modelos\SuperPrecio;

use App\Traits\UserTraits;
use App\Traits\ComprobanteTraits;
use App\Traits\PrecioCompetenciaTraits;
use Maatwebsite\Excel\Facades\Excel;

class NotificacionOC extends Command
{
    use UserTraits;
    use ComprobanteTraits;
    use PrecioCompetenciaTraits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:oc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificacion OC';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(0);
        /****************************************************************************/

        $this->envio_correo_confirmacion();
        $this->ejecutar_orden_ingreso();
        $this->orden_ingreso_ejecutada();
        $this->envio_correo_tesoreria_lq();
        $this->modificarglosahabilitacion();

        //$this->envio_correo_reparacion_levantada();
        $horaActual = date("H:i");


        if($horaActual == '07:00' || $horaActual == '08:00' || $horaActual == '09:00' ||
            $horaActual == '10:00' ||  $horaActual == '11:00' ||
            $horaActual == '12:00' ||  $horaActual == '13:00' || 
            $horaActual == '14:00' ||  $horaActual == '15:00' ||
            $horaActual == '16:00' ||  $horaActual == '17:00' ||
            $horaActual == '20:00'){


            $this->sunat_cdr();
            $this->sunat_cdr_contrato();
            $this->cambiar_fecha_vencimiento();
            $this->cambiar_parcialmente();
        }


        if($horaActual == '01:00' || $horaActual == '03:00' || $horaActual == '05:00'){
            $this->documentolgautomaticonuevo();
            $this->eliminacion_vales_arendir();
        }

        $this->guadarpdfoi();


        // //precios de supermercado
        // try{    
        //     if($horaActual == '03:00' || 
        //         $horaActual == '04:00'){
        //         DB::beginTransaction();
        //         SuperPrecio::whereDate('FECHA',date('Ymd'))->delete();
        //         $this->scrapear_plazavea('PLAZAVEA');
        //         $this->scrapear_metro('METRO');
        //         $this->scrapear_tottus('TOTTUS');
        //         $this->scrapear_wong('WONG');
        //         $lista_precios = SuperPrecio::orderby('MARCA','asc')->get();
        //         //dd($lista_precios);
        //         Excel::create('DATAAUTOMATICA_BD', function($excel) use ($lista_precios) {
        //             $excel->sheet('PRECIOS_SUPER', function($sheet) use ($lista_precios) {
        //                 $sheet->loadView('reporte/excel/listapreciossupermercados')->with('lista_precios',$lista_precios);                                               
        //             });
        //         })->store('xlsx', 'F:/Data_Drive');
        //         DB::commit();
        //     }
        // }catch(\Exception $ex){
        //     DB::rollback();
        //     dd($ex);
        // }

    }
}
