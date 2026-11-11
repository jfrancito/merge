<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDetalleDocumento extends Model
{
    protected $table = 'FE_DETALLE_DOCUMENTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';

    // public function ActivoF()
    // {
    //     return $this->hasMany('App\Modelos\FE_DETALLE_DOCUMENTO_AF', 'FE_DOCUMENTO', 'FE_DOCUMENTO');
    // }
}
