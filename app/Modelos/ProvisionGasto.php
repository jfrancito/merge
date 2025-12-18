<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProvisionGasto extends Model
{
    protected $table = 'LIQUIDACION_GASTOS_MEGE';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;

}
