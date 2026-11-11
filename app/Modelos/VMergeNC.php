<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeNC extends Model
{
    protected $table = 'VMERGENC';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}
