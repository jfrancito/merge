<?php

namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;
use DB;

class OrdenPedidoExport
{
    protected $empresa;

    public function __construct($empresa)
    {
        $this->empresa = $empresa;
    }

    public function export()
    {
      }
}
