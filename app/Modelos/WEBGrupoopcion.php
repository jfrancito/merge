<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBGrupoopcion extends Model
{
    protected $table = 'WEB.grupoopciones';
    public $timestamps=false;


    protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

    public function opcion()
    {
        return $this->hasMany('App\Modelos\WEBOpcion', 'grupoopcion_id', 'id');
    }


}
