<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PlaSerie extends Model
{
    protected $table = 'PLA_SERIE';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
