<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBRegistroImporteGastos extends Model
{
    protected $table = 'WEB.REGISTRO_IMPORTE_GASTOS';
    public $timestamps=false;

     protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}