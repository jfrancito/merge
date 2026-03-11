<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ContratoAnticipoDetalle extends Model
{
    protected $table = 'CONTRATO_ANTICIPO_DETALLE';
    protected $primaryKey = 'ID_DOCUMENTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
