<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeToken extends Model
{
    protected $table = 'FE_TOKEN';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
