<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBCategoriaActivoFijo extends Model
{
    // protected $table = 'WEB.categoriaactivofijo';
    protected $table = 'WEB.categoriaactivofijo';
    public $timestamps=false;
    protected $primaryKey = 'id';
	public $incrementing = false;
    public $keyType = 'string';
}
