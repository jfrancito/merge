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

class TareasSunat extends Command
{
    use UserTraits;
    use ComprobanteTraits;
    use PrecioCompetenciaTraits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sunat:ta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tareas Sunat';

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
        $this->documentolgautomatico();
    }
}
