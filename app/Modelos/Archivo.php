<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'ARCHIVOS';
    public $timestamps=false;
    protected $primaryKey = 'ID_DOCUMENTO';
	public $incrementing = false;
	public $keyType = 'string';
    
}
