<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DocumentoSunat extends Model
{
    protected $table = 'DOCUMENTO_SUNAT';
    protected $primaryKey = 'ID';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
