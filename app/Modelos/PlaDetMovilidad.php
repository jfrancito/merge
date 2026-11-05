<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PlaDetMovilidad extends Model
{
    protected $table = 'PLA_DETMOVILIDAD';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
