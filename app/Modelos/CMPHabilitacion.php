<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPHabilitacion extends Model
{
    protected $table = 'CMP.HABILITACION';
    public $timestamps=false;

    protected $primaryKey = 'COD_HABILITACION';
	public $incrementing = false;
    public $keyType = 'string';
    

}
