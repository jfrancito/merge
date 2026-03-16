<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeGrupoDocumento extends Model
{
    protected $table = 'FE_GRUPO_DOCUMENTO';
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';
}