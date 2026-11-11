<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ALMProducto extends Model
{
    protected $table            =   'ALM.PRODUCTO';
    public $timestamps          =   false;
    protected $primaryKey       =   'COD_PRODUCTO';
	public $incrementing        =   false;
    public $keyType             =   'string';

    public function unidadmedida()
    {
        return $this->belongsTo('App\Modelos\CMPCategoria', 'COD_CATEGORIA_UNIDAD_MEDIDA', 'COD_CATEGORIA');
    }

}



