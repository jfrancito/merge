<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeDocumento extends Model
{
    protected $table = 'VMERGEDOCUMENTOS';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}
