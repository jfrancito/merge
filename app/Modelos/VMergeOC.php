<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeOC extends Model
{
    protected $table = 'VMERGEOC';
    public $timestamps=false;
    protected $primaryKey = 'COD_ORDEN';
	public $incrementing = false;
	public $keyType = 'string';

}
