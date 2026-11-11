<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tercero extends Model
{
    protected $table = 'TERCEROS';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
