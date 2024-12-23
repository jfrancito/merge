<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class SuperPrecio extends Model
{
    protected $table = 'SUPER_PRECIOS';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
