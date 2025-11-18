<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DetalleSemanaImpulso extends Model
{
    protected $table = 'DETALLE_SEMANA_IMPULSO';
    protected $primaryKey = 'ID_DOCUMENTO';
    
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';




}
