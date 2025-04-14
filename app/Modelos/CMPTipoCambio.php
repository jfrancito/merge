<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPTipoCambio extends Model
{
    protected $table = 'CMP.TIPO_CAMBIO';
    public $timestamps = false;
    protected $primaryKey = 'FEC_CAMBIO';
    public $incrementing = false;
    public $keyType = 'string';

}



