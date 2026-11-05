<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LqgDetLiquidacionGasto extends Model
{
    protected $table = 'LQG_DETLIQUIDACIONGASTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
