<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PlaDocumentoHistorial extends Model
{
    protected $table = 'PLA_DOCUMENTO_HISTORIAL';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
