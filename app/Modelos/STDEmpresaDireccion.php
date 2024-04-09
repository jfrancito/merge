<?php

namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;

class STDEmpresaDireccion extends Model
{
    protected $table = 'STD.EMPRESA_DIRECCION';
    public $timestamps=false;
    protected $primaryKey = 'COD_DIRECCION';
	public $incrementing = false;
	public $keyType = 'string';

}
