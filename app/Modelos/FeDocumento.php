<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDocumento extends Model
{
    protected $table = 'FE_DOCUMENTO';
    public $timestamps=false;
    protected $primaryKey   =   ['ID_DOCUMENTO','DOCUMENTO_ITEM'];

    public $incrementing = false;
    public $keyType = 'string';


    public function scopeProveedorFE($query,$proveedor_id){
        if(trim($proveedor_id) != 'TODO'){
            $query->where('RUC_PROVEEDOR','=',$proveedor_id);
        }
    }


    public function scopeEstadoFE($query,$estado_id){
        if(trim($estado_id) != 'TODO'){
            $query->where('FE_DOCUMENTO.COD_ESTADO','=',$estado_id);
        }
    }


}
