<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPDetalleProducto extends Model
{
    protected $table = 'CMP.DETALLE_PRODUCTO';
    public $timestamps=false;

    protected $primaryKey = 'COD_TABLA';
	public $incrementing = false;
    public $keyType = 'string';

    public function producto()
    {
        return $this->belongsTo('App\Modelos\ALMProducto', 'COD_PRODUCTO', 'COD_PRODUCTO');
    }
    
}
