<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBRegistroValePersonalAutoriza extends Model
{
    protected $table = 'WEB.VALE_PERSONAL_AUTORIZA';
    public $timestamps=false;

     protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}