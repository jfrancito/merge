<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBTipoMotivoValeRendir extends Model
{
    protected $table = 'web.tipo_motivo';
    public $timestamps=false;
    protected $primaryKey = 'COD_MOTIVO';
    public $incrementing = false;
    public $keyType = 'string';

}



