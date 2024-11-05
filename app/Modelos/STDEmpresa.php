<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class STDEmpresa extends Model
{
    protected $table = 'STD.EMPRESA';
    public $timestamps=false;
    protected $primaryKey = 'COD_EMPR';
    public $incrementing = false;
    public $keyType = 'string';

    public function userempresacentro()
    {
        return $this->hasMany('App\Modelos\WEBUserEmpresaCentro', 'empresa_id', 'id');
    }

    public function documento_ctble()
    {
        return $this->hasMany('App\Modelos\CMPDocumentoCtble', 'COD_EMPR_RECEPTOR', 'COD_EMPR');
    }

    public function tipo_documento()
    {
        return $this->belongsTo('App\Modelos\CMPCategoria', 'COD_TIPO_DOCUMENTO', 'COD_CATEGORIA');
    }

    public function asiento()
    {
        return $this->hasMany('App\Modelos\WEBAsiento', 'COD_EMPR_CLI', 'COD_EMPR');
    }


}
