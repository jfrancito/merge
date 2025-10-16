<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TESAutorizacion extends Model
{
    protected $table = 'TES.AUTORIZACION';
    public $timestamps=false;
    protected $primaryKey = 'COD_AUTORIZACION';
	public $incrementing = false;
    public $keyType = 'string';
    
}
