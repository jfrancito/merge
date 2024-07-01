<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ViewDPagar extends Model
{
    protected $table = 'LISTA_DOCUMENTOS_PAGAR_PROGRAMACION';
    public $timestamps=false;
    protected $primaryKey = 'COD_ORDEN';
	public $incrementing = false;
	public $keyType = 'string';

}
