<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBTipoLineaValeRendir extends Model
{
    protected $table = 'web.tipo_linea';
    public $timestamps=false;
    protected $primaryKey = 'COD_LINEA';
    public $incrementing = false;
    public $keyType = 'string';

}
