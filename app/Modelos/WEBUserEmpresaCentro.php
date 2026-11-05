<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBUserEmpresaCentro extends Model
{
    protected $table = 'WEB.userempresacentros';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function empresa()
    {
        return $this->belongsTo('App\Modelos\STDEmpresa', 'empresa_id', 'COD_EMPR');
    }

    public function centro()
    {
        return $this->belongsTo('App\Modelos\ALMCentro', 'centro_id', 'COD_CENTRO');
    }

}
