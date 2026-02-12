<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VDetraccionesConPagos extends Model
{
    protected $table = 'V_DETRACCIONES_CON_PAGOS';
    public $timestamps=false;
	public $incrementing = false;
	public $keyType = 'string';

}
