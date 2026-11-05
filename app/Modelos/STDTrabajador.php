<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class STDTrabajador extends Model
{
    protected $table = 'STD.TRABAJADOR';
    public $timestamps=false;
    protected $primaryKey = 'COD_TRAB';
	public $incrementing = false;
    public $keyType = 'string';
    
}
