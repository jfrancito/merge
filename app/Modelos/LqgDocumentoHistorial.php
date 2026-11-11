<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LqgDocumentoHistorial extends Model
{
    protected $table = 'LQG_DOCUMENTO_HISTORIAL';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
