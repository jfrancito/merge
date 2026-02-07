<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDocumentoEntregableDetraccion extends Model
{
    protected $table = 'FE_DOCUMENTO_ENTREGABLE_DETRACCION';
    public $timestamps=false;
    protected $primaryKey   =   'FOLIO';
    public $incrementing = false;
    public $keyType = 'string';

}
