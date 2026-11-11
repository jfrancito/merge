<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class SemanaImpulso extends Model
{
    protected $table = 'SEMANA_IMPULSO';
    protected $primaryKey = 'ID_DOCUMENTO';
    
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';




}
