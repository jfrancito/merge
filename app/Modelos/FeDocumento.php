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

    public function scopeTipoArchivo($query,$tipoarchivo_id){
        if(trim($tipoarchivo_id) != 'TODO'){
            $query->where('FE_DOCUMENTO.MODO_REPARABLE','=',$tipoarchivo_id);
        }
    }
    public function scopeEstadoReparable($query,$estado_id){
        if(trim($estado_id) != 'TODO'){
            $query->where('FE_DOCUMENTO.IND_REPARABLE','=',$estado_id);
        }else{
            $query->whereIn('FE_DOCUMENTO.IND_REPARABLE',['1','2']);
        }
    }


    public function scopeFecha($query,$filtrofecha_id,$fecha_inicio,$fecha_fin){
        if(trim($filtrofecha_id) == 'RE'){
            $query->whereRaw("CAST(fecha_pa AS DATE) >= ? and CAST(fecha_pa AS DATE) <= ?", [$fecha_inicio,$fecha_fin]);
        }else{
            $query->whereRaw("CAST(fecha_ap AS DATE) >= ? and CAST(fecha_ap AS DATE) <= ?", [$fecha_inicio,$fecha_fin]);
        }
    }


}
