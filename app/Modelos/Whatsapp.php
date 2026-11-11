<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $table = 'whatsapp';
    public $timestamps=false;
    protected $primaryKey = 'id';
	public $incrementing = false;
    protected $connection = 'sqlsrv_w';    

}



