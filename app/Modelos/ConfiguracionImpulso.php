<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionImpulso extends Model
{
    protected $table = 'CONFIGURACION_IMPULSO';
    protected $primaryKey = 'ID_CONFIGURACION';
    
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';




}
