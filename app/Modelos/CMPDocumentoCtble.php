<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPDocumentoCtble extends Model
{
    protected $table = 'CMP.DOCUMENTO_CTBLE';
    public $timestamps=false;

    protected $primaryKey = 'COD_DOCUMENTO_CTBLE';
	public $incrementing = false;
    public $keyType = 'string';
    
    public function detalleproducto()
    {
        return $this->hasMany('App\CMPDetalleProducto', 'COD_TABLA', 'COD_ORDEN');
    }

    public function scopeProveedor($query,$proveedor_id){
        if(trim($proveedor_id) != 'TODO'){
            $query->where('COD_EMPR_EMISOR','=',$proveedor_id);
        }
    }

    public function scopeEstado($query,$estado_id){
        if(trim($estado_id) != 'TODO'){
            $query->where('FE_DOCUMENTO.COD_ESTADO','=',$estado_id);
        }
    }

}
