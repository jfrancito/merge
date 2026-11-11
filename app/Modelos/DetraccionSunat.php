<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DetraccionSunat extends Model
{
    protected $table = 'DETRACION_SUNAT';
    public $timestamps=false;
    protected $primaryKey = 'num_pres';
	public $incrementing = false;

}
