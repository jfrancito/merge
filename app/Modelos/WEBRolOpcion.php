<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBRolOpcion extends Model
{
    protected $table = 'WEB.rolopciones';
    public $timestamps=false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function opcion()
    {
        return $this->belongsTo('App\Modelos\WEBOpcion', 'opcion_id', 'id');
    }

    public function rol()
    {
        return $this->belongsTo('App\Modelos\WEBRol', 'rolopcion_id', 'rolopcion_id');
    }



}
