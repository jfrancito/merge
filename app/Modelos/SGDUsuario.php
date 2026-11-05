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
    

    public function scopeArea($query,$area_id){
        if(trim($area_id) != 'TODO'){
            $query->where('COD_CATEGORIA_AREA','=',$area_id);
        }
    }

}
