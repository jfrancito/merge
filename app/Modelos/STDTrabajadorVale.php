<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class STDTrabajadorVale extends Model
{
    protected $table = 'STD.TRABAJADOR_VALE';
    public $timestamps=false;
    protected $primaryKey = 'COD_TRABAJADOR_VALE';
	public $incrementing = false;
	public $keyType = 'string';



}