<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LqgLiquidacionGasto extends Model
{
    protected $table = 'LQG_LIQUIDACION_GASTO';
    protected $primaryKey = 'ID_DOCUMENTO';
    
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';

    public function scopeProveedorLG($query,$proveedor_id){
        if(trim($proveedor_id) != 'TODO'){
            $query->where('COD_EMPRESA_TRABAJADOR','=',$proveedor_id);
        }
    }


    public function scopeEstadoLG($query,$estado_id){
        if(trim($estado_id) != 'TODO'){
            $query->where('LQG_LIQUIDACION_GASTO.COD_ESTADO','=',$estado_id);
        }
    }



}
