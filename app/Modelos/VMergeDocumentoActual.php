<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeDocumentoActual extends Model
{
    protected $table = 'VMERGEDOCUMENTOSACTUAL';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}
