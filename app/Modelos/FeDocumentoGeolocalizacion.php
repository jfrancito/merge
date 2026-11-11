<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FeDocumentoGeolocalizacion extends Model
{
    protected $table        =   'FE_DOCUMENTO_GEOLOCALIZACION';
    public $timestamps      =   false;
    protected $primaryKey   =   'ID_DOCUMENTO';
    public $incrementing    =   false;
    public $keyType         =   'string';

}
