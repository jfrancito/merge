<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeOP extends Model
{
    protected $table = 'VMERGEOP';
    public $timestamps=false;
    protected $primaryKey = 'COD_AUTORIZACION';
	public $incrementing = false;
	public $keyType = 'string';

}
