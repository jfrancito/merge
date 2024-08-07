<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDocumento extends Model
{
    protected $table = 'FE_DOCUMENTO';
    public $timestamps=false;
    protected $primaryKey   =   ['ID_DOCUMENTO','DOCUMENTO_ITEM'];

    public $incrementing = false;
    public $keyType = 'string';

}
