<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LqgLiquidacionGasto extends Model
{
    protected $table = 'LQG_LIQUIDACION_GASTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
