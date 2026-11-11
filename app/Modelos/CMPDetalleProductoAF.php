<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPDetalleProductoAF extends Model
{
    protected $table = 'CMP.DETALLE_PRODUCTO_AF';
    public $timestamps=false;

    protected $primaryKey = 'COD_TABLA';
	public $incrementing = false;
    public $keyType = 'string';
    
}
