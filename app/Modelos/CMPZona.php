<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPZona extends Model
{
    protected $table            =   'CMP.ZONA';
    public $timestamps          =   false;
    protected $primaryKey       =   'COD_ZONA';
	public $incrementing        =   false;
    public $keyType             =   'string';
}



