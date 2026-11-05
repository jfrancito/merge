<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    public $timestamps=false;
    protected $primaryKey = 'id';
	public $incrementing = false;

}
