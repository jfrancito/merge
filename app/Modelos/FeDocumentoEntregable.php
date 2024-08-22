<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDocumentoEntregable extends Model
{
    protected $table = 'FE_DOCUMENTO_ENTREGABLE';
    public $timestamps=false;
    protected $primaryKey   =   'FOLIO';
    public $incrementing = false;
    public $keyType = 'string';

}
