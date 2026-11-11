<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TESOperacionCaja extends Model
{
    protected $table            =   'TES.OPERACION_CAJA';
    public $timestamps          =   false;
    protected $primaryKey       =   'COD_OPERACION_CAJA';
	public $incrementing        =   false;
    public $keyType             =   'string';

}



