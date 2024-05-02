<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDocumentoHistorial extends Model
{
    protected $table        =   'FE_DOCUMENTO_HISTORIAL';
    public $timestamps      =   false;
    protected $primaryKey   =   'ID_DOCUMENTO';
    public $incrementing    =   false;
    public $keyType         =   'string';

}
