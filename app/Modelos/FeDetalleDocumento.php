<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDetalleDocumento extends Model
{
    protected $table = 'FE_DETALLE_DOCUMENTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';

}
