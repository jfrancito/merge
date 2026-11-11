<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LoteImpulso extends Model
{
    protected $table = 'LOTE_IMPULSO';
    protected $primaryKey = 'ID_DOCUMENTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
