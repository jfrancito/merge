<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPContrato extends Model
{
    protected $table = 'CMP.CONTRATO';
    public $timestamps=false;
    protected $primaryKey = 'COD_CONTRATO';
	public $incrementing = false;
    public $keyType = 'string';
    
}
