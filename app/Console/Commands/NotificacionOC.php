<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use DateTime;
use App\Traits\UserTraits;

use App\Traits\ComprobanteTraits;


class NotificacionOC extends Command
{
    use UserTraits;
    use ComprobanteTraits;
    
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
        $this->orden_ingreso_ejecutada();
        $this->sunat_cdr();
        $this->ejecutar_orden_ingreso();
        $this->sunat_cdr_contrato();



        $horaActual = date("H:i");

        if($horaActual == '07:00' || 
            $horaActual == '10:00' || 
            $horaActual == '12:00' || 
            $horaActual == '14:00' || 
            $horaActual == '17:00' ||
            $horaActual == '20:00'){
            $this->cambiar_fecha_vencimiento();
            $this->cambiar_parcialmente();
        }

        // COMENTANDO NO VALE
        // $this->envio_correo_uc();
        // //CONTABILIDAD
        // $this->envio_correo_co();
        // //ADMINISTRACION
        // $this->envio_correo_adm();
        // //PROVISIONAR
        // $this->envio_correo_apcli();
        // //BAJA COMPROBANTE
        // $this->envio_correo_baja();


    }
}
