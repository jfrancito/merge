<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeFormaPago extends Model
{
    protected $table = 'FE_FORMAPAGO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
