<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeActual extends Model
{
    protected $table = 'VMERGEOC_ACTUAL';
    public $timestamps=false;
    protected $primaryKey = 'COD_ORDEN';
	public $incrementing = false;
	public $keyType = 'string';

}
