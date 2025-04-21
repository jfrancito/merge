<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use DateTime;
use App\Traits\UserTraits;
use App\Traits\ComprobanteTraits;


class OtrosNotifi extends Command
{
    use UserTraits;
    use ComprobanteTraits;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otros:not';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otros notifcacion ';

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

        \Log::error('Otros notifica.');



    }
}
