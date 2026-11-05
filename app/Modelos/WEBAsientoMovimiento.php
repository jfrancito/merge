<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBAsientoMovimiento extends Model
{
    protected $table = 'WEB.asientomovimientos';
    public $timestamps=false;
    protected $primaryKey = 'COD_ASIENTO_MOVIMIENTO';
	public $incrementing = false;
	public $keyType = 'string';


    public function asiento()
    {
        return $this->belongsTo('App\Modelos\WEBAsiento', 'COD_ASIENTO', 'COD_ASIENTO');
    }

    public function cuentacontable()
    {
        return $this->belongsTo('App\Modelos\WEBCuentaContable', 'COD_CUENTA_CONTABLE', 'id');
    }

}
