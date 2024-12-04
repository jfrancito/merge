<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DeudaTotalMerge extends Model
{
    protected $table = 'DEUDA_TOTAL_MERGE';
    public $timestamps=false;
    protected $primaryKey = 'NRO_CONTRATO';
	public $incrementing = false;

}
