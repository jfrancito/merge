<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBMaestro extends Model
{
    protected $table = 'WEB.maestros';
    public $timestamps=false;

    protected $primaryKey = 'codigoatributo';
    public $incrementing = false;
    public $keyType = 'string';

}