<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeOPActual extends Model
{
    protected $table = 'VMERGEOPACTUAL';
    public $timestamps=false;
    protected $primaryKey = 'COD_AUTORIZACION';
	public $incrementing = false;
	public $keyType = 'string';

}