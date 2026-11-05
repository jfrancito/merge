<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CMPDocAsociarCompra extends Model
{
    protected $table = 'CMP.DOC_ASOCIAR_COMPRA';
    public $timestamps=false;
    protected $primaryKey = 'COD_ORDEN';
	public $incrementing = false;
    public $keyType = 'string';
}
