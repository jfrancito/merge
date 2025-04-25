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

}



