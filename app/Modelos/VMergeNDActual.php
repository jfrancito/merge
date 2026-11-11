<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeNDActual extends Model
{
    protected $table = 'VMERGENDACTUAL';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}