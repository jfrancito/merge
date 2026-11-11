<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CONRegistroCompras extends Model
{
    protected $table = 'CON.REGISTRO_COMPRAS';
    public $timestamps=false;

    protected $primaryKey = 'COD_REGISTRO_COMPRAS';
	public $incrementing = false;
    public $keyType = 'string';

}
