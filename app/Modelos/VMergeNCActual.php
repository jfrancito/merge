<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeNCActual extends Model
{
    protected $table = 'VMERGENCACTUAL';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}