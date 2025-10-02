<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeActualAF extends Model
{
    protected $table = 'VMERGEOC_ACTFIJ';
    public $timestamps=false;
    protected $primaryKey = 'COD_ORDEN';
	public $incrementing = false;
	public $keyType = 'string';

}
