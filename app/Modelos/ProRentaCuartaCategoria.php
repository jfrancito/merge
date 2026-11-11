<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProRentaCuartaCategoria extends Model
{
    protected $table = 'PRO_RENTA_CUARTA_CATEGORIA';
    protected $primaryKey = 'ID_DOCUMENTO';
    public $timestamps=false;
    public $incrementing = false;
    public $keyType = 'string';
}
