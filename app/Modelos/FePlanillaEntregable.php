<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FePlanillaEntregable extends Model
{
    protected $table = 'FE_PLANILLA_ENTREGABLE';
    public $timestamps=false;
    protected $primaryKey   =   'ID_DOCUMENTO';
    public $incrementing = false;
    public $keyType = 'string';

}
