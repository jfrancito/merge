<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ContratoAnticipo extends Model
{
    protected $table = 'CONTRATO_ANTICIPO';
    protected $primaryKey = 'ID_DOCUMENTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
