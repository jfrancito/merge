<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBTipoImporteMotivoValeRendir extends Model
{
    protected $table = 'WEB.TIPO_IMPORTE_MOTIVO';
    public $timestamps=false;
    protected $primaryKey = 'COD_IMPORTE_MOTIVO';
    public $incrementing = false;
    public $keyType = 'string';



}



