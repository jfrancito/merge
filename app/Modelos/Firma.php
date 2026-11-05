<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table = 'FIRMAS';
    protected $primaryKey = 'ID_DOCUMENTO';
    
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';




}
