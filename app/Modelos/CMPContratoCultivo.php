<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPContratoCultivo extends Model
{
    protected $table = 'CMP.CONTRATO_CULTIVO';
    public $timestamps=false;
    protected $primaryKey = 'COD_CONTRATO';
	public $incrementing = false;
    public $keyType = 'string';
    
}
