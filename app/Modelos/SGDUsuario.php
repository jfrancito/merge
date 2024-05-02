<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class SGDUsuario extends Model
{
    protected $table = 'SGD.USUARIO';
    public $timestamps=false;
    protected $primaryKey = 'COD_USUARIO';
	public $incrementing = false;
    public $keyType = 'string';
    
}
