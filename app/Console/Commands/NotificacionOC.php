<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use DateTime;
use App\Traits\UserTraits;

class NotificacionOC extends Command
{
    use UserTraits;
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
        $this->envio_correo_uc();
        $this->envio_correo_co();
        $this->envio_correo_adm();
        $this->envio_correo_apcli();

    }
}
