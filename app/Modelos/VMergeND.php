<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VMergeND extends Model
{
    protected $table = 'VMERGEND';
    public $timestamps=false;
    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
	public $keyType = 'string';

}