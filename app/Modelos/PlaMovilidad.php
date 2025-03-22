<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PlaMovilidad extends Model
{
    protected $table = 'PLA_MOVILIDAD';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
