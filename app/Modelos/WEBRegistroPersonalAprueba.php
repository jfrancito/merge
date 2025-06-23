<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBRegistroPersonalAprueba extends Model
{
    protected $table = 'WEB.VALE_PERSONAL_APRUEBA';
    public $timestamps=false;

     protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}