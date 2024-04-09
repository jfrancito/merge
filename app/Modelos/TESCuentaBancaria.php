<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TESCuentaBancaria extends Model
{
    protected $table            =   'TES.CUENTA_BANCARIA';
    public $timestamps          =   false;
    protected $primaryKey       =   'COD_EMPR_TITULAR';
	public $incrementing        =   false;
    public $keyType             =   'string';

}



