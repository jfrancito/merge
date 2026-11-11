<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPReferecenciaAsoc extends Model
{
    protected $table = 'CMP.REFERENCIA_ASOC';
    public $timestamps=false;

    protected $primaryKey = 'COD_TABLA_ASOC';
	public $incrementing = false;
    public $keyType = 'string';
    

    public function scopeReferencia($query,$referencia_id){
        if(trim($referencia_id) != ''){
            $query->where('TXT_REFERENCIA', '=', $referencia_id);
        }
    }

}
