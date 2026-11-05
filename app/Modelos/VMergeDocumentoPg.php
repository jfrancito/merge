<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeDocumentoPg extends Model
{
    protected $table = 'VMERGEDOCUMENTOSPG';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}
