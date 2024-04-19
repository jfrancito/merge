<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPOrden extends Model
{
    protected $table = 'CMP.ORDEN';
    public $timestamps=false;

    protected $primaryKey = 'COD_ORDEN';
	public $incrementing = false;
    public $keyType = 'string';
    
    public function detalleproducto()
    {
        return $this->hasMany('App\CMPDetalleProducto', 'COD_TABLA', 'COD_ORDEN');
    }
}
