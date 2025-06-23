<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class SunatDocumento extends Model
{
    protected $table = 'SUNAT_DOCUMENTO';
    public $timestamps=false;
    protected $primaryKey = 'ID_DOCUMENTO';
	public $incrementing = false;

}
