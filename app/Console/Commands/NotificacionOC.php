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
        //USUARIO CONTACTO
        $this->orden_ingreso_ejecutada();
        //LECTURA DE CDR Y API SUNAT
        $this->sunat_cdr();
        //LECTURA DE CDR Y API SUNAT CONTRATO
        $this->sunat_cdr_contrato();


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
